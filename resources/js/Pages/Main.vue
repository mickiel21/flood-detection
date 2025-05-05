<template>
  <Head title="Main" />
  <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-800 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
              <Link
                    :href="route('welcome')"
                    class="font-semibold text-gray-900 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Home</Link
                >
                <Link
                    :href="route('login')"
                    class="ms-4 font-semibold text-gray-900 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ms-4 font-semibold text-gray-900 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
                
            </template>
        </div>
  <div class="app-main" id="parent">
    <h2 class="text-2xl font-bold text-blue-600">Angono Flood Detection</h2>

    <!-- Weather Data -->
    <div v-if="weather" class="weather-body" id="weather-body">
      <div class="location-deatils">
        <div class="city" id="city">{{ weather.name }}, {{ weather.sys.country }}</div>
        <div class="date" id="date"> {{ formattedDate }}</div>
      </div>
      <div class="weather-status">
        <div class="temp" id="temp">{{ Math.round(weather.main.temp) }}&deg;C </div>
        <div class="weather" id="weather"> {{ weather.weather[0].main }} <i
            :class="getIconClass(weather.weather[0].main)"></i> </div>
        <div class="min-max" id="min-max">{{ Math.floor(weather.main.temp_min) }}&deg;C (min) /
          {{ Math.ceil(weather.main.temp_max) }}&deg;C (max) </div>
        <div id="updated_on">Updated as of {{ formattedDate }}</div>
      </div>
      <hr>
      <div class="day-details">
        <div class="basic">Feels like {{ weather.main.feels_like }}&deg;C | Humidity {{ weather.main.humidity }}% <br>
          Pressure {{ weather.main.pressure }} mb | Wind {{ weather.wind.speed }} KMPH</div>
      </div>
    </div>

    <div v-if="weather" class="weather-body mt-3" id="weather-body">
        <WaterLevelCard :initialWaterLevel="waterLevel" />
    </div>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { shallowRef, computed, onMounted } from "vue";
import Swal from "sweetalert2";
import WaterLevelCard from '@/Components/WaterLevelCard.vue';
const weatherApi = {
  key: import.meta.env.VITE_WEATHER_API_KEY,
  baseUrl: import.meta.env.VITE_WEATHER_API_BASE_URL,
};

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
// Reactive variables
const city = shallowRef("Angono");
const weather = shallowRef(null);
const weatherStatus = shallowRef(null);
const waterLevel = shallowRef(0);

// Fetch weather data
const getWeatherReport = async () => {
  if (!city.value) {
    Swal.fire("Empty Input", "Please enter a city name", "error");
    return;
  }

  try {
    const response = await fetch(`${weatherApi.baseUrl}?q=${city.value}&appid=${weatherApi.key}&units=metric`);
    const data = await response.json();

    if (data.cod === "404") {
      Swal.fire("City Not Found", "Entered city didn't match", "warning");
      return;
    }

    weather.value = data;
    weatherStatus.value = data.weather[0].main;
    changeBg(weatherStatus.value);
  } catch (error) {
    console.error("Error fetching weather data:", error);
    Swal.fire("Error", "Failed to retrieve weather data", "error");
  }
};

const changeBg = (status) => {
  const bgImages = {
    Clouds: "../images/clouds.jpeg",
    Rain: "../images/rain.jpeg",
    Clear: "../images/clear.jpeg",
    Snow: "../images/snow.jpeg",
    Sunny: "../images/sunny.jpeg",
    Thunderstorm: "../images/thunder.jpeg",
    Drizzle: "../images/drizzle.jpeg",
    Mist: "../images/mist.jpeg",
    Haze: "../images/mist.jpeg",
    Fog: "../images/mist.jpeg",
    Default: "../images/bg1.jpeg",
  };

  document.body.style.backgroundImage = `url(${bgImages[status] || bgImages.Default})`;
};



const getIconClass = computed(() => (weatherType) => {
  const icons = {
    Rain: "fas fa-cloud-showers-heavy",
    Clouds: "fas fa-cloud",
    Clear: "fas fa-cloud-sun",
    Snow: "fas fa-snowman",
    Sunny: "fas fa-sun",
    Mist: "fas fa-smog",
    Thunderstorm: "fas fa-thunderstorm",
    Drizzle: "fas fa-thunderstorm"
  };

  return icons[weatherType] || "fas fa-cloud-sun";
});

onMounted(() => {
  getWeatherReport()
  Echo.channel('water-level')
    .listen('.WaterLevel', (event) => {
      console.log('Event Received:', event);
      waterLevel.value = event.message;
    });
});


const formattedDate = computed(() => {
  return new Date().toLocaleDateString("en-US", { weekday: "long", month: "long", day: "numeric", year: "numeric" });
});
</script>


<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto&family=Ubuntu:wght@300&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Roboto', sans-serif;
  background-image: url("../images/bg.jpg");
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
  background-image: url(../images/bg.jpg);
}

.app-main>* {
  margin-bottom: 20px;
}

.input-box {
  width: 100%;
  background: rgb(199, 255, 253);
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

.btn {
  background-image: url(../images/btn.jpeg);
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
  color: #fff !important;
  padding: 20px;
  line-height: 2rem;
  border-radius: 10px;
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
