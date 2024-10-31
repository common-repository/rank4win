jQuery(document).ready(function(){
	window.chartColors = {
		any: '#ced4da',
		poor: '#fc5252',
		mediocre: '#ff7f00',
		good: '#8bc34a',
		perfect: '#4fae33'
	};
  	Chart.defaults.global.tooltips.custom = function(tooltip) {
  		var name = jQuery(this._chart.canvas).attr('data-name');
		var tooltipEl = document.getElementById('chartjs-tooltip');
		if (tooltip.opacity === 0) {
			tooltipEl.style.opacity = 0;
			return;
		}
		tooltipEl.classList.remove('above', 'below', 'no-transform');
		if (tooltip.yAlign) {
			tooltipEl.classList.add(tooltip.yAlign);
		} else {
			tooltipEl.classList.add('no-transform');
		}
		function getBody(bodyItem) {
			return bodyItem.lines;
		}
		if (tooltip.body) {
			var bodyLines = tooltip.body.map(getBody);
			var innerHtml = '';
			bodyLines.forEach(function(body, i) {
				var myarr = body[0].split(":");
				var colors = tooltip.labelColors[i];
				var style = 'background:' + colors.backgroundColor;
				style += '; border-color:' + colors.borderColor;
				style += '; border-width: 2px';
				var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
				innerHtml += '<tr><td>' + span + myarr[1] + ' '+ name +' </td></tr>';
			});
			innerHtml += '</tbody>';
			var tableRoot = tooltipEl.querySelector('table');
			tableRoot.innerHTML = innerHtml;
		}
		var positionY = this._chart.canvas.offsetTop;
		var positionX = this._chart.canvas.offsetLeft;
		tooltipEl.style.opacity = 1;
		tooltipEl.style.left = positionX + tooltip.caretX + 'px';
		tooltipEl.style.top = positionY + tooltip.caretY + 'px';
		tooltipEl.style.fontFamily = tooltip._bodyFontFamily;
		tooltipEl.style.fontSize = tooltip.bodyFontSize;
		tooltipEl.style.fontStyle = tooltip._bodyFontStyle;
		tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
	};
	function r4w_overscore_config(a,b,c,d,e){
		var r4w_config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [a, b, c, d, e],
					backgroundColor: [
						window.chartColors.any,
						window.chartColors.poor,
						window.chartColors.mediocre,
						window.chartColors.good,
						window.chartColors.perfect,
					],
				}],
				labels: [
					'any',
					'poor',
					'mediocre',
					'good',
					'perfect',
				]
			},
			options: {
				responsive: true,
				legend: { display: false },
				tooltips: { enabled: false }
			}
		};
		return r4w_config;
	}
	window.onload = function() {
		var r4w_canvas = jQuery('canvas#r4w_dashboard_article');
		var a = r4w_canvas.attr('score-any');
		var b = r4w_canvas.attr('score-poor');
		var c = r4w_canvas.attr('score-mediocre');
		var d = r4w_canvas.attr('score-good');
		var e = r4w_canvas.attr('score-perfect');
		r4w_dashboard_article = new Chart(r4w_canvas[0].getContext('2d'), r4w_overscore_config(a,b,c,d,e));

		var r4w_canvas = jQuery('canvas#r4w_dashboard_page');
		var a = r4w_canvas.attr('score-any');
		var b = r4w_canvas.attr('score-poor');
		var c = r4w_canvas.attr('score-mediocre');
		var d = r4w_canvas.attr('score-good');
		var e = r4w_canvas.attr('score-perfect');
		r4w_dashboard_page = new Chart(r4w_canvas[0].getContext('2d'), r4w_overscore_config(a,b,c,d,e));

		jQuery('canvas').on('click', function(e) {
			var base_url = jQuery(this).attr('data-url');
			var chart_name = jQuery(this).attr('id');
			if(chart_name == "r4w_dashboard_article"){
				var slice = r4w_dashboard_article.getElementAtEvent(e);
			}
			if(chart_name == "r4w_dashboard_page"){
				var slice = r4w_dashboard_page.getElementAtEvent(e);
			}
			if (!slice.length) return;
			var label = slice[0]._model.label;
			window.location = base_url+label;
		});
	};
}); 