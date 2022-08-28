<template>
    <el-form
        ref="ruleFormRef"
        :model="ruleForm"
        status-icon
        :rules="rules"
        label-width="120px"
        class="demo-ruleForm"
        label-position="top"
    >
        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="NAME" prop="currencyName">
                        <el-input placeholder="Ex. EURO" v-model="ruleForm.currencyName" />
                    </el-form-item>
                </div>
            </el-col>

            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="SYMBOL" prop="currencySymbol">
                        <el-input placeholder="Ex. EUR" v-model="ruleForm.currencySymbol" />
                    </el-form-item>
                </div>
            </el-col>
        </el-row>

        <el-form-item>
            <el-button type="primary" @click="submitForm(ruleFormRef)">Create Currency</el-button>
            <el-button @click="resetForm(ruleFormRef)">Reset</el-button>
        </el-form-item>
  </el-form>
</template>

<script setup>
import axios from 'axios';
import { ElButton, ElNotification } from 'element-plus';
import { reactive, ref } from 'vue';
import { useRouter } from "vue-router";

const router = useRouter()

const ruleFormRef = ref()

const ruleForm = reactive({
    currencyName: '',
    currencySymbol: '',
})

const rules = reactive({
    currencyName: [
        {required: true, message: 'Field mandatory', trigger: 'blur'}
    ],

    currencySymbol:[
        { required: true, message: 'Field mandatory', trigger: 'blur' },
        { min: 3, max: 3, message: 'Length must be 3 characters', trigger: 'blur' },
    ],
})

const submitForm = (formEl) => {
    if (!formEl) return

    formEl.validate((valid) => {
        if (valid) {
            let obj = {
                currency: {
                    symbol: '',
                    name: ''
                }
            }
            obj.currency.symbol = ruleForm.currencySymbol
            obj.currency.name = ruleForm.currencyName

            axios.post("http://127.0.0.1:8000/api/currencies/", obj)
            .then(response => {

                if(response.data.success) {
                    formEl.resetFields()

                    ElNotification({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success',
                        onClose: () => router.push('/'),
                        duration: 1500
                    })
                }
            }).catch(err => {
                ElNotification({
                        title: 'Error',
                        message: err.response.data.message,
                        type: 'error',
                        duration: 1500
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