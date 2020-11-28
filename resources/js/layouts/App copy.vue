<template>
    <div>
        <!-- navbar -->
        <nav class="navbar navbar-expand-sm navbar-light bg-white shadow-sm">
            <a href="#" @click.prevent="" class="navbar-brand">Crowdfunding App</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name:'home' }">
                            Home
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name:'donations' }">
                            Donations
                        </router-link>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- content -->
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
