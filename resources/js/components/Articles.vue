<template>
    <div>
        <h2>Articles</h2>
        <div id="map"></div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted, coming from the Articles component.')
        },
    }
</script>

<style>
#map { 
    height: 300px;
}
</style>