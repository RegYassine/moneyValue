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
                    <el-form-item label="from" >
                        <el-select style="width: 100%" v-if="state.loaded" v-model="state.currencyFromId" placeholder="Sélectionner une devise">
                            <el-option v-for="(option) in state.options" :label="option.symbol + ' - ' + option.name" :value="option.id" :key="option.id"/>
                        </el-select>
                    </el-form-item>
                </div>
            </el-col>

            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="to">
                        <el-select style="width: 100%" v-model="state.currencyToId" placeholder="Selectionner une devise">
                            <el-option v-for="(option) in state.options" :label="option.name" :value="option.id" :key="option.id"/>
                        </el-select>
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
            <el-button type="primary" @click="submitForm(ruleFormRef)">Create pair</el-button>
            <el-button @click="resetForm(ruleFormRef)">Reset</el-button>
        </el-form-item>
  </el-form>
</template>

<script setup>
import axios from 'axios';
import { ElNotification } from 'element-plus';
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from "vue-router";

const router = useRouter()

const ruleFormRef = ref()

const state = reactive({
    currencyFromId: '',
    currencyToId: '',
    options: [],
    loaded: false,
    rate: 0
})

const submitForm = (formEl) => {
    if (!formEl) return

    formEl.validate((valid) => {
        if (valid) {
            if(state.currencyFromId === state.currencyToId) {

                ElNotification({
                    title: 'Error',
                    message: 'The 2 currencies are not the same',
                    type: 'error',
                    duration: 3500
                })
                return false
            }

            let pair = {
                currency_from_id: state.currencyFromId,
                currency_to_id: state.currencyToId,
                rate: state.rate
            }


            axios.post("http://127.0.0.1:8000/api/pairs/", pair)
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


onMounted(() => {
    axios.get("http://127.0.0.1:8000/api/currencies") 
    .then(response => {
        state.options.push(...response.data.data)
        state.loaded = true
    }) 
    .catch( error => console.log( 'error: ' + error ) ); 
})

</script>