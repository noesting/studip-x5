<template>
    <button
        type="submit"
        class="button x5_button_with_icon"
        :style="{ 'background-image': 'url(' + computedIcon + ')'}"
        @click="performClick()"
    >{{ text }}</button>
</template>

<script>
    import { studipIcons } from './icons';

    export default {
        props: ['text', 'action', 'icon', 'iconColor'],
        computed: {
            computedIcon() {
                return studipIcons[this.iconColor || 'blue'][this.icon];
            }
        },
        methods: {
            performClick() {
                console.log('clicked button');
                this.$emit('studipbuttonClick');
            }
        }
    };
</script>

<style lang="scss" scoped>
    .x5_button_with_icon {
        // background-image: url(http://localhost/studip-42/assets/images/icons/blue/arr_1down.svg);
        background-repeat: no-repeat;
        background-position: 95% 50%;
        width: 100%;
    }
</style>
