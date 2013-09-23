function substituteRenderer(renderer) {
  switch (renderer.toLowerCase()) 
  {
    case 'categoryaxisrenderer'   : jqRenderer=$.jqplot.CategoryAxisRenderer;
                                    break;
    case 'dateaxisrenderer'       : jqRenderer=$.jqplot.DateAxisRenderer;
                                    break;                                   
    case 'barrenderer'            : jqRenderer=$.jqplot.BarRenderer;
                                    break;                 
    case 'blockrenderer'          : jqRenderer=$.jqplot.BlockRenderer;
                                    break;                 
    case 'categoryaxisrenderer'   : jqRenderer=$.jqplot.CategoryAxisRenderer;
                                    break;
    case 'canvasaxislabelrenderer': jqRenderer=$.jqplot.CanvasAxisLabelRenderer;
                                    break;                 
    case 'logaxisrenderer'        : jqRenderer=$.jqplot.LogAxisRenderer;
                                    break;
    case 'canvasaxistickrenderer' : jqRenderer=$.jqplot.CanvasAxisTickRenderer;
                                    break;
    case 'canvastextrenderer'     : jqRenderer=$.jqplot.CanvasTextRenderer;
                                    break;
    case 'beziercurverenderer'    : jqRenderer=$.jqplot.BezierCurveRenderer;
                                    break;
    case 'ohlcrenderer'           : jqRenderer=$.jqplot.OHLCRenderer;
                                    break;
    case 'pierenderer'            : jqRenderer=$.jqplot.PieRenderer;
                                    break;
    case 'donutrenderer'          : jqRenderer=$.jqplot.DonutRenderer;
                                    break;
    case 'bubblerenderer'         : jqRenderer=$.jqplot.BubbleRenderer;
                                    break;
    case 'funnelrenderer'         : jqRenderer=$.jqplot.FunnelRenderer;
                                    break;
    case 'meterguagerenderer'     : jqRenderer=$.jqplot.MeterGuageRenderer;
                                    break;
    case 'mekkorenderer'          : jqRenderer=$.jqplot.MekkoRenderer;
                                    break;
    case 'mekkoaxisrenderer'      : jqRenderer=$.jqplot.MekkoAxisRenderer;
                                    break;
    case 'enhancedlegendrenderer' : jqRenderer=$.jqplot.EnhancedLegendRenderer;
                                    break;                                                                        
    default                       : jqRenderer=renderer;
                                    console.log('No match found for '+renderer+', could be custom data or jquery.jqplot.name so not changed');
  }
  return jqRenderer;
}

$.each({
jqplot: function(series, opts){

for (level0 in opts) {
     if (typeof opts[level0] == 'object')
     {
       for (level1 in opts[level0] )
       {
         if (typeof opts[level0][level1] == 'object')
         {
            for (level2 in opts[level0][level1])
            {
              if (typeof opts[level0][level1][level2] == 'object')
              {
                for (level3 in opts[level0][level1][level2])
                {
                  console.log(level0 + '--' + level1 + '--' + level2 + '--' + level3 + '--' + opts[level0][level1][level2][level3]);                   
                }              
              } else {
                  console.log(level0 + '--' + level1 + '--' + level2 + '--' + opts[level0][level1][level2]);                                 
                  if (level2.toLowerCase().indexOf('renderer') != -1){
                     opts[level0][level1][level2]=substituteRenderer(opts[level0][level1][level2]);
                  }
              }
            }
         } else {
              console.log(level0 + '--' + level1 + '--' + opts[level0][level1]);
              if (level1.toLowerCase().indexOf('renderer') != -1){
                  opts[level0][level1]=substituteRenderer(opts[level0][level1]);
              }
         }
       }
     } else {
         console.log(level0 + '--' + opts[level0]);
         if (level0.toLowerCase().indexOf('renderer') != -1){
              opts[level0]=substituteRenderer(opts[level0]);
         }
     }
   }

    console.log('jqplot series',series);
    console.log('jqplot options',opts);
    $.jqplot(this.jquery.attr("id"), series, opts);  
  }
  
},$.univ._import);
