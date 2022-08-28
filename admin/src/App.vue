<template>
    <div v-if="state.isAuthenticated" class="common-layout">
            <el-container>
                    <el-sideNavbar><SideNavbar /></el-sideNavbar>
                    <el-container>
                        <el-header><Header /></el-header>
                        <el-main>
                            <el-row :gutter="20">
                                <el-col :span="24">
                                    <div class="grid-content ep-bg-purple">
                                        <RouterView />
                                    </div>
                                        
                                </el-col>
                            </el-row>
                        </el-main>
                    </el-container>
            </el-container>
    </div>
    <div v-else>
        <RouterView />
    </div>
</template>

<script setup>
import { RouterView } from "vue-router";

import Header from '@/components/layout/header/Header.vue';
import SideNavbar from '@/components/layout/sideNavbar/SideNavbar.vue';
import { onMounted, reactive, watch } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter()

const state = reactive({
    isAuthenticated: false,
})

const authRedirect = () => {
    const token = localStorage.getItem('token')

    if (token !== null) {
        state.isAuthenticated = true
    } else {
        router.push('/login')
    }
}


onMounted(() => {
    authRedirect();
})

watch(() => state, (isAuthenticated, oldIsAuthenticated) => {

  }
)



</script>

<style lang="scss">
    body {
        margin: 0;
    }

    .el-sideNavbar {
        height: 100vh;
        width: auto !important;
    }
</style>