(function($) {
    /* "use strict" */


 var dzChartlist = function(){
	let draw = Chart.controllers.line.__super__.draw; //draw shadow
	var screenWidth = $(window).width();
	var btnAware = function (){
		
		$('.avtivity-card')
			.on('mouseenter', function(e) {
					var parentOffset = $(this).offset(),
					relX = e.pageX - parentOffset.left,
					relY = e.pageY - parentOffset.top;
					$(this).find('.effect').css({top:relY, left:relX})
			})
			.on('mouseout', function(e) {
					var parentOffset = $(this).offset(),
					relX = e.pageX - parentOffset.left,
					relY = e.pageY - parentOffset.top;
				$(this).find('.effect').css({top:relY, left:relX})
		});
	}
	var chartTimeline = function(){
		
		var optionsTimeline = {
			chart: {
				type: "bar",
				height: 320,
				stacked: true,
				toolbar: {
					show: false
				},
				sparkline: {
					//enabled: true
				},
				backgroundBarRadius: 5,
				offsetX: -10,
			},
			series: [
				 {
					name: "New Clients",
					data: [70, 20, 75, 20, 50, 40, 65, 15, 40, 55, 60, 20, 75, 40, 25, 70, 20, 40, 65, 50]
				},
				{
					name: "Retained Clients",
					data: [-60, -10, -50, -25, -30, -65, -22, -10, -50, -20, -70, -35, -60, -20, -30, -45, -70, -50, -45, -10]
				} 
			],
			
			plotOptions: {
				bar: {
					columnWidth: "20%",
					endingShape: "rounded",
					colors: {
						backgroundBarColors: ['rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)'],
						backgroundBarOpacity: 1,
						backgroundBarRadius: 5,
						opacity:0
					},

				},
				distributed: true
			},
			colors:['#0B2A97', '#FF9432'],
			
			grid: {
				show: true,
			},
			legend: {
				show: false
			},
			fill: {
				opacity: 1
			},
			dataLabels: {
				enabled: false,
				colors:['#0B2A97', '#FF9432'],
				dropShadow: {
					enabled: true,
					top: 1,
					left: 1,
					blur: 1,
					opacity: 1
				}
			},
			xaxis: {
				categories: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'],
				labels: {
					style: {
						colors: '#787878',
						fontSize: '13px',
						fontFamily: 'Poppins',
						fontWeight: 400
						
					},
				},
				crosshairs: {
					show: false,
				},
				axisBorder: {
					show: false,
				},
			},
			
			yaxis: {
				//show: false
				labels: {
					style: {
						colors: '#787878',
						fontSize: '13px',
						fontFamily: 'Poppins',
						fontWeight: 400
						
					},
				},
			},
			
			tooltip: {
				x: {
					show: true
				}
			}
    };
		var chartTimelineRender =  new ApexCharts(document.querySelector("#chartTimeline"), optionsTimeline);
		 chartTimelineRender.render();
	}
	
	var chartBar = function(){
		var optionsArea = {
          series: [{
            name: "Distance",
            data: [70, 50, 80, 120, 120, 80, 120, 100]
          }
        ],
          chart: {
          height: 200,
          type: 'area',
		  group: 'social',
		  toolbar: {
            show: false
          },
          zoom: {
            enabled: false
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [10],
		  colors:['#0B2A97'],
		  curve: 'smooth'
        },
        legend: {
			show:false,
          tooltipHoverFormatter: function(val, opts) {
            return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
          },
		  
        },
        markers: {
		  strokeWidth: [8],
		  strokeColors: ['#0B2A97'],
		  border:0,
		  colors:['#fff'],
          hover: {
            size: 13,
          }
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug' ],
		  labels: {
		   style: {
			  colors: '#3E4954',
			  fontSize: '14px',
			   fontFamily: 'Poppins',
			  fontWeight: 100,
			  
			},
		  },
        },
		yaxis: {
			labels: {
			offsetX:-16,
		   style: {
			  colors: '#3E4954',
			  fontSize: '14px',
			   fontFamily: 'Poppins',
			  fontWeight: 100,
			  
			},
		  },
		},
		fill: {
			colors:['#0B2A97'],
			type:'solid',
			opacity: 0
		},
		colors:['#0B2A97'],
        grid: {
          borderColor: '#f1f1f1',
		  xaxis: {
            lines: {
              show: true
            }
          }
        },
		 responsive: [
		 {
			breakpoint:1601,
			options:{
				chart: {
					height:400
				},
			},
		 }
			,{
			breakpoint: 768,
			options: {
				chart: {
					height:250
				},
				markers: {
				  strokeWidth: [4],
				  strokeColors: ['#0B2A97'],
				  border:0,
				  colors:['#fff'],
				  hover: {
					size: 6,
				  }
				},
				stroke: {
				  width: [6],
				  colors:['#0B2A97'],
				  curve: 'smooth'
				},
			}
		 }
		 ] 
        };
		var chartArea = new ApexCharts(document.querySelector("#chartBar"), optionsArea);
        chartArea.render();

	}	
	/* Function ============ */
		return {
			init:function(){
			},
			
			
			load:function(){
				btnAware();
				chartTimeline();
				chartBar();
			},
			
			resize:function(){
				
			}
		}
	
	}();

	jQuery(document).ready(function(){
	});
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000); 
		
	});

	jQuery(window).on('resize',function(){
		
		
	});     

})(jQuery);