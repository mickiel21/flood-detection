<template>
    
    <div class="app-main" id="parent">
        <div class="header">
            <h4>Get Weather</h4>
        </div>
        <div class="searchInputBox">
            <input type="text" v-model="city" class="input-box" placeholder="Enter city name" @keyup.enter="getWeatherReport" />
            <button class="btn" @click="getWeatherReport">Search</button>
        </div>
        <div class="weather-body" id="weather-body">
        </div>
            
    </div>
    
</template>

<script>

const weatherApi = {
    key: '5174a4c980abc22f0dc589db984742cf',
    baseUrl: 'https://api.openweathermap.org/data/2.5/weather'
}


export default {
    name: 'Dashboard',
    components: {
        
    },
    data() {
        return {
            city: '',
        }
    },
methods:{

    getWeatherReport(city) {
    fetch(`${weatherApi.baseUrl}?q=${city}&appid=${weatherApi.key}&units=metric`)  
        .then(weather => {   
            return weather.json(); 
        }).then(showWeaterReport);  

},

 showWeaterReport(weather) {
    let city_code=weather.cod;
    if(city_code==='400'){ 
        swal("Empty Input", "Please enter any city", "error");
        reset();
    }else if(city_code==='404'){
        swal("Bad Input", "entered city didn't matched", "warning");
        reset();
    }
    else{

    let op = document.getElementById('weather-body');
    op.style.display = 'block';
    let todayDate = new Date();
    let parent=document.getElementById('parent');
    let weather_body = document.getElementById('weather-body');
    weather_body.innerHTML =
        `
    <div class="location-deatils">
        <div class="city" id="city">${weather.name}, ${weather.sys.country}</div>
        <div class="date" id="date"> ${dateManage(todayDate)}</div>
    </div>
    <div class="weather-status">
        <div class="temp" id="temp">${Math.round(weather.main.temp)}&deg;C </div>
        <div class="weather" id="weather"> ${weather.weather[0].main} <i class="${getIconClass(weather.weather[0].main)}"></i>  </div>
        <div class="min-max" id="min-max">${Math.floor(weather.main.temp_min)}&deg;C (min) / ${Math.ceil(weather.main.temp_max)}&deg;C (max) </div>
        <div id="updated_on">Updated as of ${getTime(todayDate)}</div>
    </div>
    <hr>
    <div class="day-details">
        <div class="basic">Feels like ${weather.main.feels_like}&deg;C | Humidity ${weather.main.humidity}%  <br> Pressure ${weather.main.pressure} mb | Wind ${weather.wind.speed} KMPH</div>
    </div>
    `;
    parent.append(weather_body);
    changeBg(weather.weather[0].main);
    reset();
    }
},




 getTime(todayDate) {
    let hour =addZero(todayDate.getHours());
    let minute =addZero(todayDate.getMinutes());
    return `${hour}:${minute}`;
},

 dateManage(dateArg) {
    let days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    let months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    let year = dateArg.getFullYear();
    let month = months[dateArg.getMonth()];
    let date = dateArg.getDate();
    let day = days[dateArg.getDay()];
    return `${date} ${month} (${day}) , ${year}`
},

 changeBg(status) {
    if (status === 'Clouds') {
        document.body.style.backgroundImage = 'url("images/clouds.jpeg")';
    } else if (status === 'Rain') {
        document.body.style.backgroundImage = 'url("images/rain.jpeg")';
    } else if (status === 'Clear') {
        document.body.style.backgroundImage = 'url("images/clear.jpeg")';
    }
    else if (status === 'Snow') {
        document.body.style.backgroundImage = 'url("images/snow.jpeg")';
    }
    else if (status === 'Sunny') {
        document.body.style.backgroundImage = 'url("images/sunny.jpeg")';
    } 
    else if (status === 'Thunderstorm') {
        document.body.style.backgroundImage = 'url("images/thunder.jpeg")';
    } 
    else if (status === 'Drizzle') {
        document.body.style.backgroundImage = 'url("images/drizzle.jpeg")';
    } 
    else if (status === 'Mist' || status === 'Haze' || status === 'Fog') {
        document.body.style.backgroundImage = 'url("images/mist.jpeg")';
    }
    else {
        document.body.style.backgroundImage = 'url("images/bg1.jpeg")';
    }
},

 getIconClass(classarg) {
    if (classarg === 'Rain') {
        return 'fas fa-cloud-showers-heavy';
    } else if (classarg === 'Clouds') {
        return 'fas fa-cloud';
    } else if (classarg === 'Clear') {
        return 'fas fa-cloud-sun';
    } else if (classarg === 'Snow') {
        return 'fas fa-snowman';
    } else if (classarg === 'Sunny') {
        return 'fas fa-sun';
    } else if (classarg === 'Mist') {
        return 'fas fa-smog';
    } else if (classarg === 'Thunderstorm' || classarg === 'Drizzle') {
        return 'fas fa-thunderstorm';
    } else {
        return 'fas fa-cloud-sun';
    }
},

 reset() {
    let input = document.getElementById('input-box');
    input.value = "";
},

 addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

}

}


</script>


<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Roboto&family=Ubuntu:wght@300&display=swap');
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  font-family: 'Roboto', sans-serif;
  background-image: url("'images/bg.jpg");
  min-height: 92vh;
  overflow: auto;
  background-repeat: no-repeat;
  background-position: bottom center;
  background-size: cover;
}

.header h4 {
  color: rgb(123, 94, 227);
  font-weight: 700;
  font-size: 2.4rem;
  font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
}
.app-main {
  min-height: 10vh;
  width: 30vw;
  margin: 50px auto;
  padding: 20px;
  text-align: center;
  box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
  border-radius: 15px;
  background-image: url('images/bg.jpg'); 
}
.app-main > * {
  margin-bottom: 20px;
}
.input-box {
  width: 100%;
  background:  rgb(199, 255, 253);
  color: rgb(123, 94, 227);
  font-weight: 500;
  border: none;
  font-size: 1.7rem;
  border-radius: 10px;
  padding: 10px;
  text-align: center;
  outline: none;
  border: none;
}

.btn{
  background-image: url('images/btn.jpeg');
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  width: 120px;
  padding: 10px;
  margin: 20px;
  margin-bottom: 30px;
  border: 0;
  border-radius: 20px;
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.9);
  font-weight: bold;
  cursor: pointer;
}

.weather-body {
  color: #fff;
  padding: 20px;
  line-height: 2rem;
  border-radius: 10px;
  display: none;
  backdrop-filter: blur(10px);
  box-shadow: 0 0 20px rgba(75, 31, 31, 0.4);
}
.location-deatils {
  font-weight: bold;
}
.weather-status {
  padding: 20px;
}
.temp {
  font-size: 5rem;
  font-weight: 700;
  margin-bottom: 20px 0px;
  text-shadow: 2px 4px rgba(0, 0, 0, 0.1);
}
.weather {
  margin-top: 25px;
  font-size: 2rem;
  margin-bottom: 10px;
}
.min-max {
  font-size: 1.2rem;
  font-weight: 400;
  margin-top: 15px;
}

.day_details {
  padding: 20px;
}
.sun-detail,
.basic {
  font-size: 1rem;
}
#weather-icon {
  color: black;
}


@media screen and (max-width: 800px) {
  .app-main {
    width: 95%;
    padding: 10px;
  }
  body {
    min-height: 94vh;
  }
}

</style>
