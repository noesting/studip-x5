<template>
    <button type="submit" class="button x5_button" @click="performClick()">{{ text }}</button>
</template>

<script>
    export default {
        props: ['text', 'action'],
        methods: {
            performClick() {
                this.$emit('studipbuttonClick');
            }
        }
    };
</script>

<style lang="scss" scoped>
</style>
