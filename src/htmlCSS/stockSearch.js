var AlphaVantageAPI = require('alpha-vantage-cli').AlphaVantageAPI;

var yourApiKey = 'P3H2D9PQS4N0MNI4';
var alphaVantageAPI = new AlphaVantageAPI(yourApiKey, 'compact', true);

alphaVantageAPI.getDailyData('MSFT')
    .then(dailyData => {
        console.log("Daily data:");
        console.log(dailyData);
    })
    .catch(err => {
        console.error(err);
    });