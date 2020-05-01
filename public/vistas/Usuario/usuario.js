$(function () {
    $('.min-chart#chart-sales').easyPieChart({
      barColor: "#4caf50",
      onStep: function (from, to, percent) {
        $(this.el).find('.percent').text(Math.round(percent));
      }
    });
  });