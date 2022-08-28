
<template>
    <div>
        <h1 class="title">Currency converter</h1>
        <el-form
            ref="ruleFormRef"
            :model="state"
            status-icon
            :rules="rules"
            label-width="120px"
            class="loginForm"
            label-position="top"
        >

            <el-row :gutter="20" justify="center">
                <el-col :span="18">
                    <div class="grid-content" >
                        <el-form-item label="Email" prop="email">
                            <el-input v-model="state.email" type="email" />
                        </el-form-item>
                    </div>
                </el-col>
            </el-row>

            <el-row :gutter="20" justify="center">
                <el-col :span="18">
                    <div class="grid-content" >
                        <el-form-item label="Password" prop="password">
                            <el-input v-model="state.password" type="password" autocomplete="off" />
                        </el-form-item>
                    </div>
                </el-col>
            </el-row>

            <el-row :gutter="20" justify="center">
                <el-col :span="18">
                    <div class="grid-content" >
                    <el-form-item>
                            <el-button type="primary" @click="submitForm(ruleFormRef)">Connect</el-button>
                            <el-button @click="resetForm(ruleFormRef)">Reset</el-button>
                        </el-form-item>
                    </div>
                </el-col>
            </el-row>
    </el-form>
</div>
</template>


<style lang="scss" scoped>

    .title {
        text-align: center;
        margin-top: 50px;
    }

    .loginForm{
        margin-top: 80px;
    }
</style>

<script setup>
import axios from 'axios';
import { ElButton, ElNotification } from 'element-plus';
import { reactive, ref } from 'vue';
import { useRouter } from "vue-router";

const ruleFormRef = ref()
const router = useRouter()

const state = reactive({
  password: '',
  email: '',
})

const rules = reactive({
    password: [{
          required: true,
          message: 'Password is mandatory',
          trigger: 'blur',
    }],
    email: [
        {
            required: true,
            message: 'Email is mandatory',
            trigger: 'blur',
        },
        {
            type: 'email',
            message: 'The email is not formatted correctly',
            trigger: ['blur', 'change'],
        },
    ]
})

const submitForm = (formEl) => {
    if (!formEl) return

    formEl.validate((valid) => {
        if (valid) {
            axios.post("http://127.0.0.1:8000/api/login", {...state})
            .then(response => {
                if(response.data.success) {
                    formEl.resetFields()

                    localStorage.setItem('token', response.data.data.token)
                    
                    ElNotification({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success',
                        onClose: () => router.push('/'),
                        duration: 800
                    })
                }
            })
            .catch(err => {
                ElNotification({
                    title: 'Error',
                    message: err.response.data.message,
                    type: 'error'
                })
            });

        } else {
            return false
        }
    })
}

const resetForm = (formEl) => {
  if (!formEl) return
  formEl.resetFields()
}
</script>