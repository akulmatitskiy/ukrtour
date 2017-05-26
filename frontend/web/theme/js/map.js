/**
 * Map d3.js
 */
window.addEventListener("load", function (event) {
    var width = 900;
    var height = 600;
    var widthSvg = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

// Desktop
if (widthSvg > 599) {
        var heightSvg = Math.round(widthSvg / 1.5);
        var geometry_center = {"latitude": 48.360833, "longitude": 31.1809725};
        var geography_center = {"latitude": 49.0275, "longitude": 31.482778};

        var svg = d3.select("#map").append("svg")
                .attr("viewBox", '4.5 1.5 900 600')
                .attr("width", widthSvg)
                .attr("height", heightSvg)
                .attr("xmlns", 'http://www.w3.org/2000/svg');

        var projection = d3.geo.conicEqualArea()
                .center([0, geometry_center.latitude])
                .rotate([-geometry_center.longitude, 0])
                .parallels([46, 52])  // vsapsai: selected these parallels myself, most likely they are wrong. 46, 52
                .scale(4000) //4000
                .translate([width / 2, height / 2]); //[width / 2, height / 2]

        d3.json("/theme/js/ukraine.json", function (error, ukraine_data) {

            var path = d3.geo.path()
                    .projection(projection);

            var countries = topojson.feature(ukraine_data, ukraine_data.objects.countries);
            svg.selectAll(".country")
                    .data(countries.features)
                    .enter().append("path")
                    .attr("class", function (d) {
                        return "country " + d.id;
                    })
                    .attr("d", path);

            svg.append("path")
                    .datum(topojson.mesh(ukraine_data, ukraine_data.objects.countries, function (a, b) {
                        return a !== b;
                    }))
                    .attr("class", "country-boundary")
                    .attr("d", path);
            svg.append("path")
                    .datum(topojson.mesh(ukraine_data, ukraine_data.objects.countries, function (a, b) {
                        return a === b;
                    }))
                    .attr("class", "coastline")
                    .attr("d", path);

            var regions = topojson.feature(ukraine_data, ukraine_data.objects.regions);
            // -- areas
            svg.selectAll(".region")
                    .data(regions.features)
                    .enter().append("path")
                    .classed("region", true)
                    .attr("id", function (d) {
                        return d.id;
                    })
                    .attr("d", path)
                    .attr("onclick", function (d) {
                        var x = Math.round(projection(d.properties.label_point)[0]);
                        var y = Math.round(projection(d.properties.label_point)[1]);
                        return "showHotel('hotels-ls-" + d.id + "'," + x + "," + y + ")";
                    });

            // water-resources
            var water_group = svg.append("g")
                    .attr("id", "water-resources");

            var rivers = topojson.feature(ukraine_data, ukraine_data.objects.rivers);
            water_group.selectAll(".river")
                    .data(rivers.features)
                    .enter().append("path")
                    .attr("class", "river")
                    .attr("name", function (d) {
                        return d.properties.name;
                    })
                    .attr("d", path);

            // Add lakes after rivers so that river lines connect reservoirs, not cross them.
            var lakes = topojson.feature(ukraine_data, ukraine_data.objects.lakes);
            water_group.selectAll(".lake")
                    .data(lakes.features)
                    .enter().append("path")
                    .attr("class", "lake")  // Note: not necessary a lake, it can be a reservoir.
                    .attr("name", function (d) {
                        return d.properties.name;
                    })
                    .attr("d", path);

            // -- boundaries
            svg.append("path")
                    .datum(topojson.mesh(ukraine_data, ukraine_data.objects.regions, function (a, b) {
                        return a !== b;
                    }))
                    .classed("region-boundary", true)
                    .attr("d", path);


            // -- labels
            svg.selectAll(".region-label")
                    .data(regions.features)
                    .enter().append("text")
                    .attr("transform", function (d) {
                        return "translate(" + projection(d.properties.label_point) + ")";
                    })
                    .classed("region-label", true)
                    .selectAll("tspan")
                    .data(function (d) {
                        // Path
                        var urlPath = location.pathname;

                        if (urlPath.match(/^\/en\/?.*/g)) {
                            // en
                            return d.properties.localized_name.en.split(" ");
                        } else if (urlPath.match(/^\/ru\/?.*/g)) {
                            // ru
                            return d.properties.localized_name.ru.split(" ");
                        } else {
                            // Default - ua
                            return d.properties.localized_name.ua.split(" ");
                        }

                    })
                    .enter().append("tspan")
                    .attr("x", "0")
                    .attr("dy", function (d, i) {
                        return i > 0 ? "1.1em" : "0";
                    })
                    .text(function (d) {
                        return d + " ";
                    });

            // Markers
            // Path
            var urlPathname = location.pathname;
            var urlPrefix = '';
            if (urlPathname.match(/^\/en\/?.*/g)) {
                // en
                urlPrefix = '/en';
            } else if (urlPathname.match(/^\/ru\/?.*/g)) {
                // ru
                urlPrefix = '/ru';
            }
            d3.json(urlPrefix + "/map/marks", function (error, marks_data) {
                svg.selectAll(".mark")
                        .data(marks_data)
                        .enter()
                        .append("image")
                        .attr("class", "mark")
                        .attr("id", function (d) {
                            return "mark-" + d.id;
                        })
                        .attr("width", 12)
                        .attr("height", 18)
                        .attr("xlink:href", '/theme/img/place.png')
                        .attr("transform", function (d) {
                            var cx = projection([d.longitude, d.latitude])[0] - 6;
                            var cy = projection([d.longitude, d.latitude])[1] - 18;
                            return "translate(" + cx + "," + cy + ")";
                        })
                        .attr("onclick", function (d) {
                            var x = Math.round(projection([d.longitude, d.latitude])[0]);
                            var y = Math.round(projection([d.longitude, d.latitude])[1]);
                            return "showHotel('hotel-" + d.id + "'," + x + "," + y + ")";
                        });
            });

        });

        d3.select(self.frameElement)
                .style("width", width + "px")
                .style("height", height + "px");

    }
});
