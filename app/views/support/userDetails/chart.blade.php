   <div class="portlet box mbl">
    <div class="portlet-header">
        <div class="caption">Line Chart - Spline</div>
        <div class="tools">
            <i class="fa fa-chevron-up"></i>
            <i data-toggle="modal" data-target="#modal-config" class="fa fa-cog"></i>
            <i class="fa fa-refresh"></i>
            <i class="fa fa-times"></i>
        </div>
    </div>
    <div class="portlet-body">
        <div id="line-chart-spline" style="width: 100%; height: 300px; padding: 0px; position: relative;">
            <canvas class="flot-base" width="414" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 414px; height: 300px;"></canvas>
            <div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);">
                <div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 284px; left: 17px;">Jan</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 284px; left: 63px;">Feb</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 284px; left: 110px;">Mar</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 284px; left: 158px;">Apr</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 284px; left: 204px;">May</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 284px; left: 253px;">Jun</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 284px; left: 303px;">Jul</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 284px; left: 346px;">Aug</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 284px; left: 394px;">Sep</div>
                </div>
                <div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 272px; left: 8px;">75</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 227px; left: 1px;">100</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 182px; left: 1px;">125</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 137px; left: 1px;">150</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 92px; left: 1px;">175</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 47px; left: 1px;">200</div>
                    <div class="flot-tick-label tickLabel" style="position: absolute; top: 3px; left: 1px;">225</div>
                </div>
            </div>
            <canvas class="flot-overlay" width="414" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 414px; height: 300px;"></canvas>
            <div class="legend">
                <div style="position: absolute; width: 60px; height: 60px; top: 15px; right: 16px; opacity: 0.85; background-color: rgb(255, 255, 255);"></div>
                <table style="position:absolute;top:15px;right:16px;;font-size:smaller;color:#545454">
                    <tbody>
                        <tr>
                            <td class="legendColorBox">
                                <div style="border:1px solid #ccc;padding:1px">
                                    <div style="width:4px;height:0;border:5px solid #ffce54;overflow:hidden"></div>
                                </div>
                            </td>
                            <td class="legendLabel">Chrome</td>
                        </tr>
                        <tr>
                            <td class="legendColorBox">
                                <div style="border:1px solid #ccc;padding:1px">
                                    <div style="width:4px;height:0;border:5px solid #3DB9D3;overflow:hidden"></div>
                                </div>
                            </td>
                            <td class="legendLabel">Firefox</td>
                        </tr>
                        <tr>
                            <td class="legendColorBox">
                                <div style="border:1px solid #ccc;padding:1px">
                                    <div style="width:4px;height:0;border:5px solid #df4782;overflow:hidden"></div>
                                </div>
                            </td>
                            <td class="legendLabel">Safari</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
