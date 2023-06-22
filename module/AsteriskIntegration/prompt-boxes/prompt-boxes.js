/* global Element, NodeList, HTMLCollection */

(function (name, context, definition)
{
    'use strict';
    if (typeof window.define === 'function' && window.define.amd)
    {
        window.define(definition);
    }
    else if (typeof module !== 'undefined' && module.exports)
    {
        module.exports = definition();
    }
    else if (context.exports)
    {
        context.exports = definition();
    }
    else
    {
        context[name] = definition();
    }
})('PromptBoxes', this, function ()
{
    'use strict';

    var PromptBoxes = function (options)
    {
        if (!(this instanceof PromptBoxes))
        {
            return new PromptBoxes(options);
        }

        var defaultOptions = {
            attrPrefix: 'pb',
            speeds: {
                backdrop: 250,
                toasts: 250
            },
            alert: {
                okText: 'Ok',
                okClass: '',
                closeWithEscape: false,
                absolute: false
            },
            confirm: {
                confirmText: 'Confirm',
                confirmClass: '',
                cancelText: 'Cancel',
                cancelClass: '',
                closeWithEscape: true,
                absolute: false
            },
            prompt: {
                inputType: 'text',
                submitText: 'Submit',
                submitClass: '',
                cancelText: 'Cancel',
                cancelClass: '',
                closeWithEscape: true,
                absolute: false
            },
            toasts: {
                direction: 'top',
                max: 5,
                duration: 5000,
                showTimerBar: true,
                closeWithEscape: true,
                allowClose: false
            }
        };
        this.options = this._extend(options, defaultOptions);

        for (var property in this._prefixes)
        {
            if (this._prefixes.hasOwnProperty(property))
                this._prefixes[property] = this.options.attrPrefix + '-' + property;
        }
    };
    PromptBoxes.prototype = {
        _extend: function (source, target)
        {
            if (source === null)
            {
                return target;
            }
            for (var k in source)
            {
                if (source[k] !== null && target[k] !== source[k])
                {
                    target[k] = source[k];
                }
            }
            return target;
        },

        _prefixes: {
            toast: '',
            confirm: '',
            prompt: '',
            alert: '',
            container: '',
            backdrop: '',
            message: '',
            buttons: '',
            timerBar: ''
        },

        _destroyBase: function (elements)
        {
            var that = this;

            // Add hide animation classes
            for (var i = 0; i < elements.length; i++)
                elements[i].removeAttribute('data-show');

            // Remove escape event from body
            that._addEscapeEvent(null);

            // Wait for animations to finish then remove from DOM
            setTimeout(function ()
            {
                for (var i = 0; i < elements.length; i++)
                    elements[i].remove();
            }, that.options.speeds.backdrop);
        },

        _addEscapeEvent: function (callback)
        {
            var body$ = document.getElementsByTagName('body')[0];
            body$.onkeyup = !callback ? null : function (ev)
            {
                if (ev.keyCode === 27)
                    callback();
            };
        },

        /**
         * Clears all instances from view
         */
        clear: function ()
        {
            var that = this;

            // Remove toasts
            that._toastQueue = [];
            that._displayToasts();

            // Remove backdrop/alerts/prompts/confirms
            var elements = [];
            var classes = [that._prefixes.backdrop, that._prefixes.alert, that._prefixes.confirm, that._prefixes.prompt];
            for (var i = 0; i < classes.length; i++)
            {
                var els = document.getElementsByClassName(classes[i]);
                for (var j = 0; j < els.length; j++)
                    elements.push(els[j]);
            }

            that._destroyBase(elements);
        },

        alert: function (callback, msg, okText, opts)
        {
            var that = this;

            // Re-create options
            opts = that._extend(opts, Object.assign({}, that.options.alert));
            if (!msg)
                msg = 'This is an alert';
            if (!!okText)
                opts.okText = okText;

            // Base elements
            var backdrop$ = document.createElement('div');
            var base$ = document.createElement('div');
            base$.id = that._prefixes.container;
            base$.className = that._prefixes.alert;
            backdrop$.className = that._prefixes.backdrop;

            // Position base element as absolute
            if (opts.absolute === true)
            {
                var doc = document.documentElement;
                var top = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
                base$.style.position = 'absolute';
                base$.style.top = top + 'px';
            }

            // Message elements
            var message$ = document.createElement('div');
            message$.className = that._prefixes.message;
            message$.innerHTML = msg;

            // Buttons
            var buttons$ = document.createElement('div');
            var ok$ = document.createElement('button');
            buttons$.className = that._prefixes.buttons;
            ok$.className = opts.okClass;
            ok$.innerHTML = opts.okText;

            // Method to remove bases and return result
            var complete = function (outcome)
            {
                callback(outcome || false);
                that._destroyBase([backdrop$, base$]);
            };

            ok$.onclick = function ()
            {
                complete(true);
            };

            buttons$.appendChild(ok$);
            base$.appendChild(message$);
            base$.appendChild(buttons$);

            var body$ = document.getElementsByTagName('body')[0];
            body$.appendChild(backdrop$);
            body$.appendChild(base$);
            if (opts.closeWithEscape)
                that._addEscapeEvent(complete);

            setTimeout(function ()
            {
                ok$.focus();
                backdrop$.setAttribute('data-show', 'true');
                base$.setAttribute('data-show', 'true');
            }, 50);
        },

        confirm: function (callback, msg, confirmText, cancelText, opts)
        {
            var that = this;

            // Re-create options
            opts = that._extend(opts, Object.assign({}, that.options.confirm));
            if (!msg)
                msg = 'Please confirm this action';
            if (!!confirmText)
                opts.confirmText = confirmText;
            if (!!cancelText)
                opts.cancelText = cancelText;

            // Base elements      
            var backdrop$ = document.createElement('div');
            var base$ = document.createElement('div');
            base$.id = that._prefixes.container;
            base$.className = that._prefixes.confirm;
            backdrop$.className = that._prefixes.backdrop;

            // Position base element as absolute
            if (opts.absolute === true)
            {
                var doc = document.documentElement;
                var top = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
                base$.style.position = 'absolute';
                base$.style.top = top + 'px';
            }

            // Message elements
            var message$ = document.createElement('div');
            message$.className = that._prefixes.message;
            message$.innerHTML = msg;

            // Buttons
            var buttons$ = document.createElement('div');
            var confirm$ = document.createElement('button');
            var cancel$ = document.createElement('button');
            buttons$.className = that._prefixes.buttons;
            confirm$.className = opts.confirmClass;
            confirm$.innerHTML = opts.confirmText;
            cancel$.className = opts.cancelClass;
            cancel$.innerHTML = opts.cancelText;

            // Method to remove bases and return result
            var complete = function (outcome)
            {
                callback(outcome || false);
                that._destroyBase([backdrop$, base$]);
            };

            cancel$.onclick = function ()
            {
                complete();
            };
            confirm$.onclick = function ()
            {
                complete(true);
            };

            buttons$.appendChild(cancel$);
            buttons$.appendChild(confirm$);
            base$.appendChild(message$);
            base$.appendChild(buttons$);

            var body$ = document.getElementsByTagName('body')[0];
            body$.appendChild(backdrop$);
            body$.appendChild(base$);
            if (opts.closeWithEscape)
                that._addEscapeEvent(complete);

            setTimeout(function ()
            {
                confirm$.focus();
                backdrop$.setAttribute('data-show', 'true');
                base$.setAttribute('data-show', 'true');
            }, 50);
        },

        prompt: function (callback, msg, inputType, submitText, cancelText, opts)
        {
            var that = this;

            // Re-create options
            opts = that._extend(opts, Object.assign({}, that.options.prompt));
            if (!msg)
                msg = 'Are you sure?';
            if (!!inputType)
                opts.inputType = inputType;
            if (!!submitText)
                opts.submitText = submitText;
            if (!!cancelText)
                opts.cancelText = cancelText;

            // Base elements
            var backdrop$ = document.createElement('div');
            var base$ = document.createElement('div');
            base$.id = that._prefixes.container;
            base$.className = that._prefixes.prompt;
            backdrop$.className = that._prefixes.backdrop;

            // Position base element as absolute
            if (opts.absolute === true)
            {
                var doc = document.documentElement;
                var top = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
                base$.style.position = 'absolute';
                base$.style.top = top + 'px';
            }

            // Message elements
            var message$ = document.createElement('div');
            message$.className = that._prefixes.message;
            message$.innerHTML = msg;

            // Input element
            var input$ = document.createElement('input');
            input$.type = opts.inputType;

            // Buttons
            var buttons$ = document.createElement('div');
            var submit$ = document.createElement('button');
            var cancel$ = document.createElement('button');
            buttons$.className = that._prefixes.buttons;
            submit$.className = opts.submitClass;
            submit$.setAttribute('disabled', 'disabled');
            submit$.innerHTML = opts.submitText;
            cancel$.className = opts.cancelClass;
            cancel$.innerHTML = opts.cancelText;

            // Method to remove bases and return result
            var complete = function (value)
            {
                callback(value || false);
                that._destroyBase([backdrop$, base$]);
            };

            // Add input event. Listen to enter command.
            input$.onkeyup = function (ev)
            {
                var val = input$.value;
                if (val === '')
                    return submit$.setAttribute('disabled', 'disabled');

                submit$.removeAttribute('disabled');
                if (ev.keyCode !== 13)
                    return;

                complete(val);
            };

            cancel$.onclick = function ()
            {
                complete();
            };
            submit$.onclick = function ()
            {
                var value = input$.value;
                if (value === '')
                    return input$.focus();

                complete(value);
            };

            buttons$.appendChild(cancel$);
            buttons$.appendChild(submit$);
            base$.appendChild(message$);
            base$.appendChild(input$);
            base$.appendChild(buttons$);

            var body$ = document.getElementsByTagName('body')[0];
            body$.appendChild(backdrop$);
            body$.appendChild(base$);
            if (opts.closeWithEscape)
                that._addEscapeEvent(complete);

            setTimeout(function ()
            {
                input$.focus();
                backdrop$.setAttribute('data-show', 'true');
                base$.setAttribute('data-show', 'true');
            }, 50);
        },

        _toastQueue: [],

        _addToast: function (el$, className, opts)
        {
            var that = this;

            // Remove excess toast if we're over our limit and to give room for our new toast
            if (that._toastQueue.length >= opts.max)
            {
                that._toastQueue.splice(opts.max - 1, (that._toastQueue.length - (opts.max - 1)));
            }

            // Add toast to queue
            that._toastQueue.unshift({id: el$.id, className: className});

            // Trigger animation once loaded to DOM
            setTimeout(function ()
            {
                el$.className = className + ' show';
            }, 50);
        },

        _removeToast: function (el$)
        {
            var that = this;

            // Loop through the queue and remove the requested toast from the queue
            for (var i = 0; i < that._toastQueue.length; i++)
            {
                if (that._toastQueue[i].id === el$.id)
                {
                    that._toastQueue.splice(i, 1);
                    break;
                }
            }
        },

        _displayToasts: function (opts)
        {
            var that = this;
            opts = opts || that.options.toasts;

            // Method that physically removes elements from the screen
            var destroyToast = function (el$)
            {
                el$.className = 'gone ' + el$.className;
                setTimeout(function ()
                {
                    try
                    {
                        el$.remove();
                    }
                    catch (ex)
                    {
                        console.error(ex);
                    }
                }, that.options.speeds.toasts);
            };

            // Get current element list from dom
            var toastList = document.getElementsByClassName(that._prefixes.toast);

            // Loop through current queue and remove any elements that are no longer present
            for (var i = 0; i < toastList.length; i++)
            {
                var tId = toastList[i].id;
                var exists = false;
                for (var j = 0; j < that._toastQueue.length; j++)
                {
                    if (tId === that._toastQueue[j].id)
                    {
                        exists = true;
                    }
                }
                if (!exists)
                {
                    destroyToast(toastList[i]);
                }
            }

            // Calculate margin of toasts to show
            var height = 0;
            for (var i = 0; i < that._toastQueue.length; i++)
            {
                height += 10;

                var el = document.getElementById(that._toastQueue[i].id);
                if (!el)
                    break;

                if (i > 0)
                {
                    var prevEl = document.getElementById(that._toastQueue[i - 1].id);
                    if (prevEl)
                        height += prevEl.clientHeight;
                }

                if (opts.direction === 'bottom')
                {
                    el.style.marginBottom = height + 'px';
                }
                else
                {
                    el.style.marginTop = height + 'px';
                }
            }

        },

        toast: function (msg, stateClass, opts)
        {
            var that = this;

            // Re-create options
            opts = that._extend(opts, Object.assign({}, that.options.toasts));

            // Build base elements
            var className = that._prefixes.toast + ' ' + opts.direction + ' ' + (stateClass || 'info');
            var base$ = document.createElement('div');
            base$.innerHTML = msg;
            base$.id = 'toast_' + that._toastQueue.length + '_' + Math.random();
            base$.className = className;

            // Show close option?
            if (opts.allowClose)
            {
                var close$ = document.createElement('a');
                close$.href = "javascript:void(0)";
                close$.innerHTML = '&times;';
                close$.className = 'toast-close';
                close$.onclick = function ()
                {
                    that._removeToast(base$);
                    that._displayToasts(opts);
                };
                base$.appendChild(close$);
                base$.setAttribute('data-close', true);
            }

            // Add to body
            document.getElementsByTagName('body')[0].appendChild(base$);

            // Run animations
            that._addToast(base$, className, opts);
            that._displayToasts(opts);

            // Set duration logic
            if (opts.duration)
            {
                if (opts.showTimerBar)
                {
                    var timerBar$ = document.createElement('div');
                    timerBar$.style.position = 'absolute';
                    timerBar$.style.bottom = 0;
                    timerBar$.style.left = 0;
                    timerBar$.style.width = 0;
                    timerBar$.style.height = '4px';
                    timerBar$.style.background = 'rgba(0, 0, 0, 0.25)';
                    timerBar$.style.transition = 'width linear ' + opts.duration + 'ms';
                    timerBar$.className = that._prefixes.timerBar;
                    base$.appendChild(timerBar$);

                    // Add timer countdown
                    setTimeout(function ()
                    {
                        timerBar$.style.width = '100%';
                    }, 50);
                }

                // Hide toast once completed time
                setTimeout(function ()
                {
                    that._removeToast(base$);
                    that._displayToasts(opts);
                }, opts.duration);
            }
        },

        success: function (msg, opts)
        {
            this.toast(msg, 'success', opts);
        },

        error: function (msg, opts)
        {
            this.toast(msg, 'error', opts);
        },

        info: function (msg, opts)
        {
            this.toast(msg, 'info', opts);
        }
    };

    return PromptBoxes;
});

Element.prototype.remove = function ()
{
    if (this.parentElement)
        this.parentElement.removeChild(this);
};

NodeList.prototype.remove = HTMLCollection.prototype.remove = function ()
{
    for (var i = this.length - 1; i >= 0; i--)
    {
        if (this[i] && this[i].parentElement)
        {
            this[i].parentElement.removeChild(this[i]);
        }
    }
};