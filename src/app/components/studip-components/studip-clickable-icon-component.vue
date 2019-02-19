<template>
    <img :class="['icon-role-clickable', iconShape, 'icon-shape-custom']" :src="imageSource">
</template>

<script>
    import { studipIcons } from './icons';

    export default {
        props: ['icon_name', 'color', 'action'],
        methods: {
            performClick() {
                console.log('clicked button');
            }
        },
        computed: {
            imageSource: function() {
                return studipIcons[this.color || 'blue'][this.icon_name];
            },

            iconShape: function() {
                return 'icon-shape-' + this.icon_name;
            }
        }
    };
</script>

<style lang="scss" scoped>
    .icon-shape-custom {
        width: 1.2em;
        height: 1.2em;
    }
</style>
