<template>  
    <el-menu
        class="el-menu-vertical-demo"
        :collapse="obj.isCollapse"
        @open="handleOpen"
        @close="handleClose"
        active-text-color="#ffd04b"
        router=true
    >
    <el-radio-group class="radio-group" 
        v-model="obj.isCollapse"
        :label="!obj.isCollapse">
        <el-radio-button :label="!obj.isCollapse">
            <el-icon> <expand /> </el-icon>
        </el-radio-button>
    </el-radio-group>

    <div v-for="(item, index) in menuList" :key="index">
        <SideNavbarItem :index="index" :item="item"/>
    </div>
  </el-menu>
</template>

<script setup>
import {
  User,
  Folder,
  Menu as IconMenu,
  Setting,
  Expand,
  DataLine,
  Coin
} from '@element-plus/icons-vue'

import { reactive, ref, onUpdated } from 'vue'

import SideNavbarItem from "@/components/layout/sideNavbar/SideNavbarItem.vue";

// State
const obj = reactive({
  isCollapse: true
});

const menuList = ref([
  {
      icon: IconMenu,
      title: 'Home',
      path: '/home'
  },
  {
      icon: DataLine,
      title: 'Analytics',
      path: '/analytics'
  },
  {
      icon: Coin,
      title: 'Currency',
      path: '/currencies/create'
  }
])

</script>

<style scoped lang="scss">

  .el-menu {
      height: 100%;
      padding-top: 25px;

      &.el-menu-vertical-demo:not(.el-menu--collapse) {
          width: 200px;
          min-height: 400px;
      }

      & > .radio-group {
          display: flex;
          flex-direction: column;
          align-items: center;
          margin-bottom: 25px;
      }
  }
  
  a {
    text-decoration: none;
  }
</style>