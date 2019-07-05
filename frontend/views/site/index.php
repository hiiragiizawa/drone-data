<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<div id="vue" class="site-index">
    <div class="row">
        <template v-for="(sensor, index) in sensors">
            <div class="col-sm-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{index}}</div>
                    <div class="panel-body">
                        {{sensor}}
                    </div>
                </div>
            </div>
        </template>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <line-chart :data="sensors.a" :timestamp="last_created_at" size="10" label="Sensor 1 Data" title="Sensor"></line-chart>
        </div>
        <div class="col-sm-6">
            <line-chart :data="sensors.b" :timestamp="last_created_at" size="20" label="Sensor 1 Data" title="Sensor"></line-chart>
        </div>
    </div>
</div>
<?php
$js = <<< JS
new Vue({
    el: '#vue',
    data: {
        sensors: [],
        last_created_at: 0,
    },
    methods: {
        fetchData: function() {
            var self = this;
            $.ajax({
                type: "GET",
                url:  "http://localhost/drone-data/frontend/web/api/fetch?timestamp=" + self.last_created_at,
                success: function(data) {
                    if (data) {
                        self.sensors = data.data;

                        self.sensor1 = data.data.a;
                        self.sensor2 = data.data.b;

                        self.last_created_at = data.timestamp;

                        self.data.push({
                            t: data.timestamp,
                            y: data.data.a,
                        });
                        self.data2.push({
                            t: data.timestamp,
                            y: data.data.b,
                        });
                    }
                }
            })
        },
        randomValue() {
            return Math.random() * (10) - 5;
        },
        countDown() {
            this.fetchData();
        }
    },
    mounted() {
        // Getting the latest data
        // this.last_created_at = Date.now() / 1000;

        window.setInterval(() => {
            this.countDown();
        }, 1000);
    },
});

Vue.component('line-chart', {
    extends: VueChartJs.Line,
    props:['data', 'timestamp', 'size', 'label', 'title'],
    data() {
        return {
            labels: [],
            values: [],
        };
    },
    computed: {
        chartData: function() {
            return this.values;
        },
        chartLabels: function() {
            return this.labels;
        }
    },
    mounted () {
        this.labels = Array.apply(null, {length: this.size}).map(Number.call, Number);

        this.renderChart({
            labels: this.labels,
            datasets: [{
                label: this.label,
                backgroundColor: 'transparent',
                borderColor: 'red',
                data: this.chartData,
                lineTension: 0,
            }]
        }, {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: this.title,
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Time'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            }
        })
    },
    watch: {
        timestamp: function () {
            this.values.push(this.data);

            if (this.values.length > this.size) {
                this.values.shift();
            }

            this.\$data._chart.update();
        }
    }
})

JS;

$this->registerJs($js);
?>
