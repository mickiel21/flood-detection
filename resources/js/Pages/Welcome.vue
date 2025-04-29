<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue'; 

const imagePath = ref('/images/Sleeping-all-Day-unscreen.gif');

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="outer-bg">

                <div class="over-lay">

                <div class="bg-img"></div>

                <div class="centered-box">

                    <div class="inner-bg">
                    <img :src="imagePath" class="logo">
                    </div>

                    <div class="content">
                    <h2>Flood Detection<br>Forecasts</h2>
                    </div>

                    <Link :href="route('main')">
                        <button id="btn" class="btn">Get Started</button>
                    </Link>

                    
                    <p class="para">Check any weather</p>
                </div>

                </div>

                </div>
        </div>
    </div>
</template>

<style scoped>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}

.bg-img{
  background-image: url(../images/background.jpeg);
  position: fixed;
  left: 0;
  width: 100%;
  height: 590px;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  filter: blur(5px);
  z-index: -1;
}

div.outer-bg{
  border-radius: 15px;
}

.outer-bg{
  background-image: url(../images/background.jpeg);
  background-position: center;
  background-repeat: no-repeat;
  background-size: contain;
  height: 590px; 
  width: 100%;
}

.centered-box {
  text-align: center;
  position: fixed;
  top: 50%;
  left: 50%;
  height: 400px;
  width: 250px;
  transform: translate(-50%, -50%);
  padding: 20px;
  border-radius: 20px; 
  backdrop-filter: blur(10px);
  box-shadow: 0 0 20px rgba(75, 31, 31, 0.4);
}

.inner-bg{
  text-align: center;
}

.logo{
  width: 200px;
}

.content{
  text-align: center;
  height: 50px;
  color: rgb(123, 94, 227);
  text-shadow: 0 0 10px rgb(255, 255, 255), 0 0 20px #ffffff, 0 0 30px #ffffff;
}

.btn{
  background-image: url(../images/_berenice_.gif);
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  width: 120px;
  padding: 10px;
  margin: 50px;
  margin-bottom: 30px;
  border: 0;
  border-radius: 20px;
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.9);
  font-weight: bold;
  cursor: pointer;
}

.para{
  font-size: 15px;
  color: rgb(255, 255, 255);
  margin: 0;
  text-shadow: 0 0 10px rgb(0, 0, 0), 0 0 20px #000000, 0 0 30px #000000;
}


</style>
