<template>
    <el-form
        ref="ruleFormRef"
        :model="state"
        status-icon
        :rules="rules"
        label-width="120px"
        label-position="top"
    >
        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="First Currency - NAME" prop="currencyFromName">
                        <el-input placeholder="Ex. EURO" v-model="state.currencyFromName" />
                    </el-form-item>
                </div>
            </el-col>

            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="First Currency - SYMBOL" prop="currencyFromSymbol">
                        <el-input placeholder="Ex. EUR" v-model="state.currencyFromSymbol" />
                    </el-form-item>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="Second Currency - NAME" prop="currencyToName">
                        <el-input placeholder="Ex. DOLLAR" v-model="state.currencyToName" />
                    </el-form-item>
                </div>
            </el-col>

            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="Second Currency - SYMBOL" prop="currencyToSymbol">
                        <el-input placeholder="Ex. USD" v-model="state.currencyToSymbol" />
                    </el-form-item>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content" >
                     <el-form-item label="Rate" prop="rate">
                        <el-input-number style="width: 100%" v-model="state.rate" :precision="8" :step="0.1" :min="0" :max="10" />
                    </el-form-item>
                </div>
            </el-col>
        </el-row>

        <el-form-item>
            <el-button type="primary" @click="submitForm(ruleFormRef)">Update Pair</el-button>
            <el-button @click="resetForm(ruleFormRef)">Reset</el-button>
        </el-form-item>
  </el-form>
</template>

<script setup>
import axios from 'axios';
import { ElButton, ElNotification } from 'element-plus';
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from "vue-router";

const route = useRoute();

onMounted(() => {
    // route.params.id
    console.log()
    axios.get(`http://127.0.0.1:8000/api/pairs/${route.params.id}`) 
        .then( response => {
            if(response.data.success) {
                const { data } = response.data;
                state.currencyFromName = data.currency_from_id.name
                state.currencyFromSymbol = data.currency_from_id.symbol
                state.currencyToName = data.currency_to_id.name
                state.currencyToSymbol = data.currency_to_id.symbol
                state.rate = data.rate
            } 
        })
        .catch( error => console.log( 'error: ' + error.response ) ); 
})

const router = useRouter()

const ruleFormRef = ref()

const state = reactive({
    currencyFromName: '',
    currencyFromSymbol: '',
    currencyToName: '',
    currencyToSymbol: '',
    rate: 0
})

const rules = reactive({
    currencyFromName: [
        {required: true, message: 'Field mandatory', trigger: 'blur'}
    ],

    currencyFromSymbol:[
        { required: true, message: 'Field mandatory', trigger: 'blur' },
        { min: 3, max: 3, message: 'Length must be 3 characters', trigger: 'blur' },
    ],

    currencyToName: [{required: true, message: 'Field mandatory', trigger: 'blur'}],

    currencyToSymbol: [
        { required: true, message: 'Field mandatory', trigger: 'blur'}, 
        { min: 3, max: 3, message: 'Length must be 3 characters', trigger: 'blur' }
    ],

    rate: [{ trigger: 'blur', required: true }]
})

const submitForm = (formEl) => {
    if (!formEl) return

    formEl.validate((valid) => {
        if (valid) {
            let pair = {
                currencies: {
                    from: {
                        symbol: '',
                        name: ''
                    },
                    to: {
                        symbol: '',
                        name: ''
                    }
                },
                rate: 0
            }
            pair.currencies.from.symbol = state.currencyFromSymbol
            pair.currencies.from.name = state.currencyFromName
            pair.currencies.to.symbol = state.currencyToSymbol
            pair.currencies.to.name = state.currencyToName
            pair.rate = state.rate

            console.log(pair)
            axios.put(`http://127.0.0.1:8000/api/pairs/${route.params.id}`, pair).then(response => {
                if(response.data.success) {
                    ElNotification({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success',
                        onClose: () => router.push('/'),
                        duration: 1500
                    })
                }
            }).catch(err => console.error(err));
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