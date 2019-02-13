<template>
    <img :class="['icon-role-clickable', iconShape]" :src="imageSource">
</template>

<script>
    export default {
        props: ['icon_name', 'color', 'action'],
        methods: {
            performClick() {
                console.log('clicked button');
            }
        },
        computed: {
            imageSource: function() {
                return this.src_root + '/' + this.color + '/' + this.icon_name + '.svg';
            },

            iconShape: function() {
                return 'icon-shape-' + this.icon_name;
            }
        },
        data() {
            return {
                src_root: 'http://localhost/studip-42/assets/images/icons/'
            };
        }
    };
</script>

<style lang="scss" scoped>
</style>
