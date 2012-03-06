$.extend($.ui.mouse,
{
   _mouseInit: function()
   {
		var self = this;

		this.element
			.bind('mousedown.'+this.widgetName, function(event, extEvent) {
				if (extEvent)
					return self._mouseDown(extEvent);
				else
				    return self._mouseDown(event);
			})
			.bind('click.'+this.widgetName, function(event) {
				if(self._preventClickEvent) {
					self._preventClickEvent = false;
					event.stopImmediatePropagation();
					return false;
				}
			});

		// Prevent text selection in IE
		if ($.browser.msie) {
			this._mouseUnselectable = this.element.attr('unselectable');
			this.element.attr('unselectable', 'on');
		}

		this.started = false;
	}
});
