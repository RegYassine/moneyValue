<template>
    <el-popconfirm
        confirm-button-text="Oui"
        cancel-button-text="Non"
        title="Are you sure you want to disconnect ?"
        @confirm="confirmEvent"
        @cancel="cancelEvent"
    >
        <template #reference>
            <el-button type="danger" :icon="User">Disconnect</el-button>
        </template>
    </el-popconfirm>
</template>


<script setup>
import { User } from '@element-plus/icons-vue';
import axios from 'axios';
import { ElNotification } from 'element-plus';
import { useRouter } from 'vue-router';

const router = useRouter()

const confirmEvent = () => {
    axios.post("http://127.0.0.1:8000/api/logout/")
            .then(response => {
                if(response.data.success) {
                    localStorage.removeItem('token')

                    ElNotification({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success',
                        onClose: () => router.push('/login'),
                        duration: 1500
                    })
                }})


    
}
const cancelEvent = () => {
    return false
}

</script>