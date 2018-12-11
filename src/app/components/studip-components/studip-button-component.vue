<template>
    <button type="submit" class="button" @click="performClick()">{{ text }}</button>
</template>

<script>
    export default {
        props: ['text', 'action'],
        methods: {
            performClick() {
                console.log('clicked button');
                this.$emit('studipbuttonClick');
            }
        }
    };
</script>

<style lang="scss" scoped>
</style>

