@extends('layouts.app')
<style>
    /* Thay đổi chiều cao của phần chứa biểu đồ */
    #chartContainer {
        height: 400px;
        width: 80%;
        margin: 0 auto;
    }

    #chartContainer2 {
        height: 400px;
        width: 80%;
        margin: 0 auto;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center col-md-12">
            <div class="col-2 float-end">
                <div class="card">
                    <div class="card-header">{{('Mục khác')}}</div>
                    <div class="card-body"></div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Thống kê') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{-- Hiển thị biểu đồ thống kê lượt xem theo từng danh mục và thể loại--}}
                        <div style="width: 90%; margin: 0 auto;">
                            <canvas id="categoryBarChart" width="400" height="400"></canvas>
                        </div>

                        <div style="width: 90%; margin: 0 auto;" class="mt-3">
                            <canvas id="typeBarChart" width="400" height="400"></canvas>
                        </div>
                        {{--Mã js lấy dữ liệu và tạo biểu đồ cột bằng thư viện chartjs--}}
                        <script>
                            // Dữ liệu từ truy vấn $statistics
                            var categoryNames = @json($statistics->pluck('category_name'));
                            var viewCountsByCategory = @json($statistics->pluck('total_views'));

                            // Dữ liệu từ truy vấn $types
                            var typeNames = @json($types->pluck('type_name'));
                            var viewCountsByType = @json($types->pluck('total_views'));

                            // Màu sắc cho các dataset trên biểu đồ
                            var colors = [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(153, 102, 255, 0.8)',
                                'rgba(255, 159, 64, 0.8)',
                                'rgba(72, 201, 176, 0.8)',
                                'rgba(231, 233, 237, 0.8)',
                                'rgba(151, 187, 205, 0.8)',
                                'rgba(220, 118, 51, 0.8)'
                                // Thêm các màu sắc khác tùy ý tại đây
                            ];

                            // Tạo biểu đồ Bar Chart cho danh mục sách
                            var ctxCategory = document.getElementById('categoryBarChart').getContext('2d');
                            var categoryBarChart = new Chart(ctxCategory, {
                                type: 'bar', // Sử dụng kiểu biểu đồ cột dọc
                                data: {
                                    labels: categoryNames,
                                    datasets: [{
                                        label: 'Danh mục sách',
                                        data: viewCountsByCategory,
                                        backgroundColor: colors.slice(0, categoryNames.length).map(color => color.replace("0.8)", "0.4)")), // Thêm opacity 0.5 cho màu sắc
                                        fill: true,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        x: {
                                            beginAtZero: true, // Hiển thị trục x bắt đầu từ 0
                                            stacked: true,
                                            grid: {
                                                color: 'rgba(0, 0, 0, 0.1)',
                                            },
                                            ticks: {
                                                fontColor: 'rgba(0, 0, 0, 0.7)',
                                            }
                                        },
                                        y: {
                                            stacked: true,
                                            grid: {
                                                color: 'rgba(0, 0, 0, 0.1)',
                                            },
                                            ticks: {
                                                fontColor: 'rgba(0, 0, 0, 0.7)',
                                                stepSize: 1000,
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false, // Ẩn chú thích của biểu đồ danh mục sách
                                        },
                                        title: {
                                            display: true,
                                            text: 'Biểu đồ lượt xem theo danh mục sách',
                                            font: {
                                                size: 20,
                                                weight: 'bold',
                                            },
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                            titleFont: {
                                                size: 16,
                                            },
                                            bodyFont: {
                                                size: 14,
                                            },
                                            displayColors: false,
                                            callbacks: {
                                                label: function (context) {
                                                    var label = context.dataset.label || '';
                                                    if (label) {
                                                        label += ': ';
                                                    }
                                                    label += context.parsed.y;
                                                    return label;
                                                }
                                            }
                                        },
                                        datalabels: {
                                            anchor: 'end',
                                            align: 'end',
                                            color: 'rgba(255, 255, 255, 0.8)',
                                            font: {
                                                size: 14,
                                            },
                                            formatter: function (value, context) {
                                                return value.toLocaleString(); // Định dạng chú thích hiển thị giá trị lượt xem
                                            }
                                        }
                                    }
                                }
                            });

                            // Tạo biểu đồ Bar Chart cho thể loại sách
                            var ctxType = document.getElementById('typeBarChart').getContext('2d');
                            var typeBarChart = new Chart(ctxType, {
                                type: 'bar', // Sử dụng kiểu biểu đồ cột dọc
                                data: {
                                    labels: typeNames,
                                    datasets: [{
                                        label: 'Thể loại sách',
                                        data: viewCountsByType,
                                        backgroundColor: colors.slice(0, typeNames.length).map(color => color.replace("0.8)", "0.3)")), // Thêm opacity 0.5 cho màu sắc
                                        fill: true,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        x: {
                                            beginAtZero: true, // Hiển thị trục x bắt đầu từ 0
                                            stacked: true,
                                            grid: {
                                                color: 'rgba(0, 0, 0, 0.1)',
                                            },
                                            ticks: {
                                                fontColor: 'rgba(0, 0, 0, 0.7)',
                                            }
                                        },
                                        y: {
                                            stacked: true,
                                            grid: {
                                                color: 'rgba(0, 0, 0, 0.1)',
                                            },
                                            ticks: {
                                                fontColor: 'rgba(0, 0, 0, 0.7)',
                                                stepSize: 1000,
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false, // Ẩn chú thích của biểu đồ thể loại sách
                                        },
                                        title: {
                                            display: true,
                                            text: 'Biểu đồ lượt xem theo thể loại sách',
                                            font: {
                                                size: 20,
                                                weight: 'bold',
                                            },
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                            titleFont: {
                                                size: 16,
                                            },
                                            bodyFont: {
                                                size: 14,
                                            },
                                            displayColors: false,
                                            callbacks: {
                                                label: function (context) {
                                                    var label = context.dataset.label || '';
                                                    if (label) {
                                                        label += ': ';
                                                    }
                                                    label += context.parsed.y;
                                                    return label;
                                                }
                                            }
                                        },
                                        datalabels: {
                                            anchor: 'end',
                                            align: 'end',
                                            color: 'rgba(255, 255, 255, 0.8)',
                                            font: {
                                                size: 14,
                                            },
                                            formatter: function (value, context) {
                                                return value.toLocaleString(); // Định dạng chú thích hiển thị giá trị lượt xem
                                            }
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
