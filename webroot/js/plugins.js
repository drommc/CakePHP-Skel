// TODO Add a plugin to easily trigger popin based on colorbox on a[target=popin] - can be backported from the latest projects
// TODO Add a plugin for making a form submitted through Ajax, using Ajaxform

// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());


// place any jQuery/helper plugins in here, instead of separate, slower script files.

// Plugin for making a div totally clickable
// Usage: add a "data-clickable=jquerySelector" attribute to clickable elements
!function($) {
	$('body')
		.on('click.clickable', '[data-clickable]', function(e) {
			if (!$(e.target).is('a')) {
				window.location = $(this).find($(this).data('clickable')).attr('href');
			}
		})
		.find('[data-clickable]').css('cursor', 'pointer');
}(window.jQuery);

// Plugin for turning a form with fieldsets into Twitter bootstrap compatible tabs
// it initializes the first one having an error
// Usage: $(selector).twbTabbableForm()
// 	HTML5 data attributes can be used to customize the rendered markup
// 		- data-prevtab: adds a "Previous" button to the tab with the attribute value as text
// 		- data-nexttab: adds a "Next" button to the tab with the attribute value as text
!function($) {
	$.fn.twbTabbableForm = function(tabsPosition, tabIdPrefix) {
		return this.each(function() {
			var $form = $(this),
				$nav = $('<ul class="nav nav-tabs" />'),
				currentTab = 0,
				additionalClass = '';

			if (typeof(tabIdPrefix) === 'undefined') {
				tabIdPrefix = '';
			}

			currentTab = tabIdPrefix + currentTab.toString();

			function makeTab(index) {
				var anchor = tabIdPrefix + index.toString(),
					$fieldset = $(this).attr('id', anchor),
					labelText = $fieldset.children('legend').hide().text(),
					nextLinkText = $fieldset.data('nexttab'),
					prevLinkText = $fieldset.data('prevtab'),
					$pagingButtons = '';

				$nav.append('<li><a href="#' + anchor + '" data-toggle="tab">' + labelText + '</a></li>');

				if (prevLinkText || nextLinkText) {
					$pagingButtons = $fieldset.find('div.submit');
					if (!$pagingButtons.length) {
						$pagingButtons = $('<div class="submit" />').appendTo($fieldset);
					}

					if (prevLinkText) {
						$('<button>' + prevLinkText + '</button>')
							.addClass('btn btn-primary pref')
							.prepend('<i class="icon-chevron-left icon-white"></i>')
							.prependTo($pagingButtons)
							.on('click', function(e) {
								e.preventDefault();
								$nav.find('li.active').prev('li').find('a').tab('show');
							});
					}
					if (nextLinkText) {
						$('<button>' + nextLinkText + '</button>')
							.addClass('btn btn-primary next')
							.append('<i class="icon-chevron-right icon-white"></i>')
							.appendTo($pagingButtons)
							.on('click', function(e) {
								e.preventDefault();
								$nav.find('li.active + li > a').tab('show');
							});
					}
				}
			}

			switch (tabsPosition) {
				case 'bottom':
					additionalClass = 'tabs-below';
					break;
				case 'left':
					additionalClass = 'tabs-left';
					break;
				case 'right':
					additionalClass = 'tabs-right';
					break;
				case 'top':
				default:
					additionalClass = '';
			}

			$form
				.wrap('<div class="tabbable ' + additionalClass + '" />')
				.addClass('tab-content')
				.before($nav)
				.children('fieldset').addClass('tab-pane').each(makeTab);

			if ($form.has('.error').length) {
				currentTab = $form.find('.error:first').closest('.tab-pane').attr('id');
			}
			$nav.find('a[href="#' + currentTab + '"]').tab('show');
		});
	}
}(window.jQuery);