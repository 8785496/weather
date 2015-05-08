function chart(sity) {
    var margin = {top: 20, right: 20, bottom: 30, left: 50};
    var width = 400 - margin.left - margin.right;
    var height = 200 - margin.top - margin.bottom;
    var parseDate = d3.time.format("%d-%m-%y %H:%M:%S").parse;
    var x = d3.time.scale().range([0, width]);
    var y = d3.scale.linear().range([height, 0]);
    var xAxis = d3.svg.axis().scale(x).orient("bottom").ticks(5).tickFormat(d3.time.format('%H:%M'));
    var yAxis = d3.svg.axis().scale(y).orient("left").ticks(5);
    var line = d3.svg.line()
            .x(function (d) {
                return x(d.date);
            })
            .y(function (d) {
                return y(d.temp);
            });
    var svg = d3.select("#" + sity).append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    d3.json("index.php?history=" + sity, function (error, data) {
        if(!data || data.length < 2){
            return false;
        }

        data.forEach(function (d) {
            d.date = parseDate(d.date);
            d.temp = +d.temp;
        });

        x.domain(d3.extent(data, function (d) {
            return d.date;
        }));
        y.domain(d3.extent(data, function (d) {
            return d.temp;
        }));

        svg.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + height + ")")
                .call(xAxis);

        svg.append("g")
                .attr("class", "y axis")
                .call(yAxis)
                .append("text")
                .attr("transform", "rotate(-90)")
                .attr("y", 6)
                .attr("dy", ".71em")
                .style("text-anchor", "end")
                .text("T, °C");

        svg.append("path")
                .datum(data)
                .attr("class", "line")
                .attr("d", line);
    });
};
