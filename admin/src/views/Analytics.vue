<script setup>
import axios from 'axios';
import { onMounted, reactive } from 'vue';

const state = reactive({
    pairs: null,
})

onMounted(() => {
    axios.get("http://127.0.0.1:8000/api/analytics") 
        .then( response => state.pairs = response.data ) 

})
</script>

<template>
    <main v-if="state.pairs !== null">
        <el-table :data="state.pairs.data" style="width: 100%; height: 85vh">

            <el-table-column label="ID" width="100">
                <template #default="scope">
                    <div style="display: flex; align-items: center">
                        <span style="margin-left: 10px">{{ scope.row.id }}</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column label="from" width="450">
                <template #default="scope">
                    <div style="display: flex; align-items: center">
                        <span style="margin-left: 10px">{{ scope.row.currency_from_id.symbol }} ({{ scope.row.currency_from_id.name }})</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column label="to" width="450">
                <template #default="scope">
                    <div style="display: flex; align-items: center">
                        <span style="margin-left: 10px">{{ scope.row.currency_to_id.symbol }} ({{ scope.row.currency_to_id.name }})</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column label="Total Number of conversions" width="900">
                <template #default="scope">
                    <div style="display: flex; align-items: center">
                        <span style="margin-left: 10px">{{ scope.row.convertion.count }}</span>
                    </div>
                </template>
            </el-table-column>
        </el-table>
    </main>
</template>

<style lang="scss" scoped>
    .addPairBtn {
        margin-bottom: 25px;
    }
</style>