<template>
  <div class="app-main" id="parent">
    <div class="header">
      <h4>Get Weather</h4>
    </div>
    <div class="searchInputBox">
      <input type="text" v-model="city" class="input-box" placeholder="Enter city name" @keyup.enter="getWeatherReport" />
      <button class="btn" @click="getWeatherReport">Search</button>
    </div>
    <div class="weather-body" ref="weatherBody">
      <div v-if="weatherData">
        <div class="location-deatils">
          <div class="city">{{ weatherData.name }}, {{ weatherData.sys.country }}</div>
          <div class="date">{{ dateManage(new Date()) }}</div>
        </div>
        <div class="weather-status">
          <div class="temp">{{ Math.round(weatherData.main.temp) }}°C</div>
          <div class="weather">
            {{ weatherData.weather[0].main }}
            <i :class="getIconClass(weatherData.weather[0].main)"></i>
          </div>
          <div class="min-max">{{ Math.floor(weatherData.main.temp_min) }}°C (min) / {{ Math.ceil(weatherData.main.temp_max) }}°C (max)</div>
          <div id="updated_on">Updated as of {{ getTime(new Date()) }}</div>
        </div>
        <hr />
        <div class="day-details">
          <div class="basic">
            Feels like {{ weatherData.main.feels_like }}°C | Humidity {{ weatherData.main.humidity }}% <br />
            Pressure {{ weatherData.main.pressure }} mb | Wind {{ weatherData.wind.speed }} KMPH
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Dashboard',
  data() {
    return {
      city: '',
      weatherData: null,
      weatherApi: {
        key: '5174a4c980abc22f0dc589db984742cf',
        baseUrl: 'https://api.openweathermap.org/data/2.5/weather'
      }
    };
  },
  methods: {
    async getWeatherReport() {
      if (!this.city.trim()) {
        swal('Empty Input', 'Please enter any city', 'error');
        return;
      }
      try {
        const response = await fetch(`${this.weatherApi.baseUrl}?q=${this.city}&appid=${this.weatherApi.key}&units=metric`);
        const data = await response.json();

        if (data.cod === '404') {
          swal("Bad Input", "Entered city didn't match", "warning");
          this.city = '';
          return;
        }

        this.weatherData = data;
        this.changeBg(data.weather[0].main);
        this.city = '';
      } catch (error) {
        swal('Error', 'Something went wrong fetching the weather.', 'error');
      }
    },
    getTime(date) {
      const hour = this.addZero(date.getHours());
      const minute = this.addZero(date.getMinutes());
      return `${hour}:${minute}`;
    },
    dateManage(dateArg) {
      const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      return `${dateArg.getDate()} ${months[dateArg.getMonth()]} (${days[dateArg.getDay()]}) , ${dateArg.getFullYear()}`;
    },
    changeBg(status) {
      const images = {
        Clouds: 'clouds.jpeg',
        Rain: 'rain.jpeg',
        Clear: 'clear.jpeg',
        Snow: 'snow.jpeg',
        Sunny: 'sunny.jpeg',
        Thunderstorm: 'thunder.jpeg',
        Drizzle: 'drizzle.jpeg',
        Mist: 'mist.jpeg',
        Haze: 'mist.jpeg',
        Fog: 'mist.jpeg'
      };
      const image = images[status] || 'bg1.jpeg';
      document.body.style.backgroundImage = `url("images/${image}")`;
    },
    getIconClass(weatherMain) {
      const icons = {
        Rain: 'fas fa-cloud-showers-heavy',
        Clouds: 'fas fa-cloud',
        Clear: 'fas fa-cloud-sun',
        Snow: 'fas fa-snowman',
        Sunny: 'fas fa-sun',
        Mist: 'fas fa-smog',
        Thunderstorm: 'fas fa-bolt',
        Drizzle: 'fas fa-cloud-rain'
      };
      return icons[weatherMain] || 'fas fa-cloud-sun';
    },
    addZero(i) {
      return i < 10 ? '0' + i : i;
    }
  }
};
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
  background-image: url("images/bg.jpg");
  min-height: 92vh;
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
  width: 90%;
  max-width: 500px;
  margin: 50px auto;
  padding: 20px;
  text-align: center;
  box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
  border-radius: 15px;
  background-color: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(8px);
}

.input-box {
  width: 100%;
  background: rgb(199, 255, 253);
  color: rgb(123, 94, 227);
  font-weight: 500;
  font-size: 1.7rem;
  border-radius: 10px;
  padding: 10px;
  text-align: center;
  outline: none;
  border: none;
}

.btn {
  background-image: url('images/btn.jpeg');
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  width: 120px;
  padding: 10px;
  margin-top: 20px;
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
  margin-top: 20px;
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
  text-shadow: 2px 4px rgba(0, 0, 0, 0.1);
}
.weather {
  font-size: 2rem;
  margin-top: 20px;
}
.min-max {
  font-size: 1.2rem;
  font-weight: 400;
  margin-top: 15px;
}

.basic {
  font-size: 1rem;
  margin-top: 20px;
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
