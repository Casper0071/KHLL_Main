<template>
    <div id="app">
        <nav>
            <router-link to="/">Dashboard</router-link> |
            <router-link to="/components">components</router-link>
        </nav>

        <router-view /> <!-- hier komen je pagina's van Vue Router -->
    </div>
</template>
