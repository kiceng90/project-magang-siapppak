"use strict";
var KTProjectOverview = function() {
    var t = KTUtil.getCssVariableValue("--bs-primary"),
        e = KTUtil.getCssVariableValue("--bs-light-primary"),
        a = KTUtil.getCssVariableValue("--bs-success"),
        r = KTUtil.getCssVariableValue("--bs-light-success"),
        o = KTUtil.getCssVariableValue("--bs-gray-200"),
        n = KTUtil.getCssVariableValue("--bs-gray-500");
    return {
        init: function() {
            var s, i;
            ! function() {
                var t = document.getElementById("project_overview_chart");
                if (t) {
                    var e = t.getContext("2d");
                    new Chart(e, {
                        type: "doughnut",
                        data: {
                            datasets: [{
                                data: [20, 22, 54, 4],
                                backgroundColor: ["#cf1919", "#ffb300", "#2fd12c", "#000000"],
                                borderWidth: 0
                            }],
                            labels: ["Off Track", "Progress", "On Track", "No Update"]
                        },
                        options: {
                            chart: {
                                fontFamily: "inherit",
                                borderWidth: 0
                            },
                            cutoutPercentage: 75,
                            responsive: !0,
                            maintainAspectRatio: !1,
                            cutout: "75%",
                            title: {
                                display: !1
                            },
                            animation: {
                                animateScale: !0,
                                animateRotate: !0
                            },
                            tooltips: {
                                enabled: !0,
                                intersect: !1,
                                mode: "nearest",
                                bodySpacing: 5,
                                yPadding: 10,
                                xPadding: 10,
                                caretPadding: 0,
                                displayColors: !1,
                                backgroundColor: "#20D489",
                                titleFontColor: "#ffffff",
                                cornerRadius: 4,
                                footerSpacing: 0,
                                titleSpacing: 0
                            },
                            plugins: {
                                legend: {
                                    display: !1
                                }
                            }
                        }
                    })
                }

                var t = document.getElementById("chart");
                if (t) {
                    var e = t.getContext("2d");
                    new Chart(e, {
                        type: "doughnut",
                        data: {
                            datasets: [{
                                data: [20, 22, 54, 4],
                                backgroundColor: ["#cf1919", "#ffb300", "#2fd12c", "#000000"],
                                borderWidth: 0
                            }],
                            labels: ["Off Track", "Progress", "On Track", "No Update"]
                        },
                        options: {
                            chart: {
                                fontFamily: "inherit"
                            },
                            cutoutPercentage: 75,
                            responsive: !0,
                            maintainAspectRatio: !1,
                            cutout: "75%",
                            title: {
                                display: !1
                            },
                            animation: {
                                animateScale: !0,
                                animateRotate: !0
                            },
                            tooltips: {
                                enabled: !0,
                                intersect: !1,
                                mode: "nearest",
                                bodySpacing: 5,
                                yPadding: 10,
                                xPadding: 10,
                                caretPadding: 0,
                                displayColors: !1,
                                backgroundColor: "#20D489",
                                titleFontColor: "#ffffff",
                                cornerRadius: 4,
                                footerSpacing: 0,
                                titleSpacing: 0
                            },
                            plugins: {
                                legend: {
                                    display: !1
                                }
                            }
                        }
                    })
                }
            }(), s = document.getElementById("kt_project_overview_graph"), i = parseInt(KTUtil.css(s, "height")), s && new ApexCharts(s, {
                    series: [{
                        name: "Incomplete",
                        data: [70, 70, 80, 80, 75, 75, 75]
                    }, {
                        name: "Complete",
                        data: [55, 55, 60, 60, 55, 55, 60]
                    }],
                    chart: {
                        type: "area",
                        height: i,
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: !1
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    fill: {
                        type: "solid",
                        opacity: 1
                    },
                    stroke: {
                        curve: "smooth",
                        show: !0,
                        width: 3,
                        colors: [t, a]
                    },
                    xaxis: {
                        categories: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug"],
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        labels: {
                            style: {
                                colors: n,
                                fontSize: "12px"
                            }
                        },
                        crosshairs: {
                            position: "front",
                            stroke: {
                                color: t,
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: !0,
                            formatter: void 0,
                            offsetY: 0,
                            style: {
                                fontSize: "12px"
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: n,
                                fontSize: "12px"
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: "none",
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: "none",
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: !1,
                            filter: {
                                type: "none",
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: "12px"
                        },
                        y: {
                            formatter: function(t) {
                                return t + " tasks"
                            }
                        }
                    },
                    colors: [e, r],
                    grid: {
                        borderColor: o,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: !0
                            }
                        }
                    },
                    markers: {
                        colors: [e, r],
                        strokeColor: [t, a],
                        strokeWidth: 3
                    }
                }).render(),
                function() {
                    var t = document.querySelector("#kt_pendapatan_table");
                    if (!t) return;
                    t.querySelectorAll("tbody tr").forEach((t => {
                        const e = t.querySelectorAll("td");
                    }));
                    const e = $(t).DataTable({
                            info: !1,
                            order: []
                        });
                }(),
                function() {
                    var t = document.querySelector("#kt_dashboard_table");
                    if (!t) return;
                    t.querySelectorAll("tbody tr").forEach((t => {
                        const e = t.querySelectorAll("td");
                    }));
                    const e = $(t).DataTable({
                            info: !1,
                            order: []
                        });
                }()
        }
    }
}();
KTUtil.onDOMContentLoaded((function() {
    KTProjectOverview.init()
}));