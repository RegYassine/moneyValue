<template>
  <el-page-header title="back" @back="goBack" :icon="ArrowLeft" :content="route.toto"></el-page-header>
</template>

<script setup>
import { ArrowLeft } from '@element-plus/icons-vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const goBack = () => router.back();

</script>

<style lang="scss">
.el-page-header {
    display: flex;
    align-items: center;
    &__left {
        align-items: center;
    }
}
</style>