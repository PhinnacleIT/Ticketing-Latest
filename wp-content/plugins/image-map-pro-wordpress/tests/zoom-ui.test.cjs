const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const { test } = require('node:test');

const bundle = fs.readFileSync(path.join(__dirname, '..', 'js', 'client', 'main.js'), 'utf8');
const zoomClass = bundle.slice(bundle.indexOf('key:"createButtons"'));
const match = zoomClass.match(/key:"insertUI",value:(function\(\)\{.*?\})\},\{key:"createScrollMessage"/);
assert.ok(match, 'Locate the production zoom insertUI method');
const insertUI = vm.runInNewContext('(' + match[1] + ')');

for (const enableZooming of [false, true]) {
    for (const enableButtons of [false, true]) {
        for (const left of [false, true]) {
            test(`zoom=${enableZooming}, buttons=${enableButtons}, left=${left}`, () => {
                const appended = [];
                const context = {
                    store: {
                        state: {
                            zooming: { enable_zooming: enableZooming, enable_zoom_buttons: enableButtons },
                            object_list: { enable_object_list: left, menu_style: 'on-top', menu_position: 'right' },
                        },
                        getUIWrap() {
                            return {
                                querySelector(selector) {
                                    return { appendChild: button => appended.push({ selector, button }) };
                                },
                            };
                        },
                    },
                };
                if (enableZooming && enableButtons) {
                    context.buttons = { zoomInButton: 'in', zoomOutButton: 'out' };
                }
                insertUI.call(context);
                assert.deepEqual(appended, enableZooming && enableButtons ? [
                    { selector: left ? '.imp-ui-bottom-left' : '.imp-ui-bottom-right', button: 'in' },
                    { selector: left ? '.imp-ui-bottom-left' : '.imp-ui-bottom-right', button: 'out' },
                ] : []);
            });
        }
    }
}
