const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const { test } = require('node:test');

const bundle = fs.readFileSync(path.join(__dirname, '..', 'assets', 'js', 'frontend', 'script.min.js'), 'utf8');
const sourceMap = JSON.parse(Buffer.from(bundle.split('base64,')[1].trim(), 'base64').toString('utf8'));
const source = sourceMap.sourcesContent[0];
const cartDefinition = source.slice(source.indexOf('const CART = {'), source.indexOf('seat_map: function()'));

function loadCart(saved) {
    const storage = new Map(saved === undefined ? [] : [['35100_35101', JSON.stringify(saved)]]);
    const warnings = [];
    const context = {
        localStorage: {
            getItem: key => storage.get(key) ?? null,
            setItem: (key, value) => storage.set(key, value),
        },
        Cookies: { set() {} },
        console: { warn: message => warnings.push(message) },
        $: () => ({
            data: key => ({ sid: 35100, rid: 35101 })[key],
            attr: () => '[]',
        }),
    };
    vm.runInNewContext(cartDefinition + '}; globalThis.cart = CART;', context);
    context.cart.init();
    return {
        cart: context.cart,
        warnings,
        saved: () => JSON.parse(storage.get('35100_35101')),
    };
}

test('repeated selection preserves other seats, areas, quantities and extra services', () => {
    const first = { id: 'A1', price: 100, extra_service: [{ name: 'Drink', price: 5, qty: 1 }] };
    const second = { id: 'A2', price: 100, extra_service: [] };
    const area = { id: 'GA', price: 50, qty: 2, extra_service: [[], []] };
    const state = loadCart([first, second, area]);
    state.cart.map_add_item('A1', 100);
    state.cart.map_add_item('GA', 50, 2);
    assert.deepEqual(state.saved(), [first, second, area]);
    assert.equal(state.warnings.length, 0);
    state.cart.remove('A2');
    state.cart.map_add_item('A3', 100);
    assert.deepEqual(state.saved(), [first, area, { id: 'A3', price: 100, extra_service: [] }]);
});

test('repairs previously saved null entries before lookup, removal and persistence', () => {
    const seat = { id: 'A1', price: 100, extra_service: [] };
    const state = loadCart([null, seat, null]);
    assert.deepEqual(state.saved(), [seat]);
    assert.equal(state.warnings.length, 1);
    assert.equal(state.cart.check_item('A1').id, 'A1');
    assert.equal(state.cart.check_item('missing'), false);
    state.cart.remove('missing');
    state.cart.map_add_item('A2', 100);
    state.cart.remove('A1');
    assert.deepEqual(state.saved(), [{ id: 'A2', price: 100, extra_service: [] }]);
    assert.deepEqual(loadCart(state.saved()).saved(), state.saved());
});

test('fresh and fully damaged carts support adding and removing seats', () => {
    for (const saved of [undefined, [], [null, null]]) {
        const state = loadCart(saved);
        assert.deepEqual(state.saved(), []);
        state.cart.map_add_item('A1', 100);
        state.cart.map_add_item('A1', 100);
        assert.equal(state.saved().length, 1);
        state.cart.remove('A1');
        assert.deepEqual(state.saved(), []);
    }
});

test('object clicks initialize a missing sidebar before processing the seat', () => {
    const start = source.indexOf('function mb_objectClick( shapeTitle )');
    const clickHandler = source.slice(start, source.indexOf('mb_areaPlus();', start));
    for (const sidebarLength of [0, 1]) {
        let initialized = 0;
        const warnings = [];
        const context = {
            $: () => ({ length: sidebarLength, show() {}, hide() {} }),
            console: { warn: message => warnings.push(message) },
            mb_mapInit: () => initialized++,
            dataSeatBooked: ['booked-seat'],
        };
        context.$.inArray = (value, items) => items.indexOf(value);
        vm.runInNewContext(clickHandler + 'mb_objectClick("booked-seat");', context);
        assert.equal(initialized, sidebarLength === 0 ? 1 : 0);
        assert.equal(warnings.length, initialized);
    }
});
