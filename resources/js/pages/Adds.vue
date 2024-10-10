<script>

import { mapActions, mapGetters } from 'vuex'
import api from '../service/api'

export default {
    name: 'Adds',
    data () {
        return {
            showDialog: false,
            addData: {
                company_id: null,
                title: null,
                text: null,
                status: null,
                url: null,
                impressions_count: null,
                crm: 0,
                budget: 0,
                button_text: null
            },
            method: null,
            button_texts: [{ name: 'Смотреть' }, { name: 'Оставить заявку' }, { name: 'Скачать' }, { name: 'Подробнее' }],
            statuses: [{ name: 'Активен' }, { name: 'В ожидании' }, { name: 'В архиве' }]
        }
    },
    mounted () {
        api.get('/api/adds').then(value => this.saveAdds(value.data.data))
    },
    computed: {
        ...mapGetters(['adds', 'loading', 'companiesList'])
    },
    methods: {
        ...mapActions([
            'saveAdds',
            'pushAdd',
            'showError',
            'deleteAddById',
            'replaceAdd',
            'saveCompaniesList'
        ]),

        addAdd () {
            this.method = 'create'
            this.showDialog = true
        },

        updateAdd (id) {
            this.method = 'update'
            api.get(`/api/adds/${id}`).then(value => this.addData = value.data.data)
            this.showDialog = true
        },

        cancelAddingAdd (event) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы действительно хотите отменить процесс добавления объявления?`,
                header: 'Подтверждение отмены',
                accept: () => {
                    this.resetAddData()
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text'
            })
        },

        addAddHandle (event) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы собираетесь добавить объявление, действительно хотите продолжить?`,
                header: 'Подтверждение добавления',
                accept: () => {
                    api.post('/api/adds', this.addData).then(value => {
                        this.pushAdd(value.data.data)
                        this.$notification.success('Объявление добавлено')
                        this.resetAddData()
                    })
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text '
            })
        },

        updateAddHandle (event) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы собираетесь изменить данные объявления, действительно хотите продолжить?`,
                header: 'Подтверждение редактирования',
                accept: () => {
                    api.put(`/api/adds/${this.addData.id}`, this.addData)
                            .then(value => {
                                this.$notification.success('Данные компании обновлены')
                                this.replaceAdd(value.data.data)
                                this.resetAddData()

                            })
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text '
            })
        },

        deleteAdd (event, id) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы действительно хотите удалить объявление?`,
                header: 'Подтверждение удаления',
                accept: () => {
                    api.delete(`/api/adds/${id}`)
                            .then(value => {
                                this.deleteAddById(value.data.data)
                                this.$notification.success('Объявление удалено')
                            })
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text '
            })
        },

        resetAddData () {
            this.addData = {
                company_id: null,
                title: null,
                text: null,
                status: null,
                url: null,
                impressions_count: null,
                crm: null,
                budget: 0,
                button_text: null
            }
            this.method = null
            this.showDialog = false
        },

        showDialogHandler () {
            api.get('/api/companies/list').then(result => this.saveCompaniesList(result.data.data))
        },

        getChipColor (status) {
            switch (status) {
                case 'В архиве':
                    return { background: 'lightgray', color: 'white' }
                case 'Активен':
                    return { background: 'lightgreen', color: 'white' }
                case 'В ожидании':
                    return { background: 'lightblue', color: 'white' }
                default:
                    return ''
            }
        }
    },
}
</script>

<template>
    <Dialog v-model:visible="showDialog" :style="{ width: '40vw'}" modal @show="showDialogHandler">
        <template #header>
            <div class="text-4xl" v-if="method === 'create'">Добавление объявления</div>
            <div class="text-4xl" v-else-if="method === 'update'">Редактирование объявления</div>
        </template>

        <div class="gap-2 w-full">

            <div class="field w-full">
                <label for="title">Заголовок</label>
                <InputText id="title" class="w-full" v-model="addData.title" :loading="loading"
                           fluid></InputText>
            </div>

            <div class="field w-full">
                <label for="text">Текст объявления</label>
                <Textarea id="text" class="w-full" :rows="5" v-model="addData.text" :loading="loading"
                           fluid></Textarea>
            </div>

            <div class="field w-full">
                <label for="url">Ссылка</label>
                <InputText id="url" class="w-full" v-model="addData.url" :loading="loading" fluid></InputText>
            </div>

            <div class="field w-full">
                <label for="name">Статус</label>
                <Select v-model="addData.status" :options="statuses" optionValue="name" optionLabel="name"
                        class="w-full"></Select>
            </div>

            <div class="field w-full">
                <label for="password">Компания</label>
                <Select class="w-full" v-model="addData.company_id" :options="companiesList" optionValue="id" optionLabel="company_name"
                        filter></Select>

            </div>

            <div class="field w-full">
                <label for="password">Кнопка</label>
                <Select class="w-full" v-model="addData.button_text" :options="button_texts" optionValue="name" optionLabel="name">
                    <template #option="slot">
                        <div class="w-full p-1">
                            <Button :label="slot.option.name" outlined class="w-full"></Button>
                        </div>
                    </template>
                </Select>

            </div>

            <div class="field w-full">
                <label for="budget">Бюджет</label>
                <InputNumber mode="currency" currency="RUB" :min="0" showButtons
                             id="budget" class="w-full" v-model="addData.budget" :loading="loading" fluid></InputNumber>
            </div>

            <div class="field w-full">
                <label for="crm">СРМ</label>
                <InputNumber :min="0" id="crm" showButtons class="w-full" v-model="addData.crm" :loading="loading" fluid></InputNumber>
            </div>

            <div class="field w-full">
                <label for="impressions_count">Количество просмотров</label>
                <InputNumber :min="1" id="impressions_count" showButtons class="w-full" v-model="addData.impressions_count" :loading="loading" fluid></InputNumber>
            </div>

        </div>

        <template #footer>
            <Button label="Отменить" text severity="danger" @click="cancelAddingAdd" :loading="loading" autofocus/>
            <Button label="Сохранить" v-if="method === 'create'" outlined severity="success" :loading="loading"
                    @click="addAddHandle" autofocus/>
            <Button label="Сохранить" v-else-if="method === 'update'" outlined severity="success" :loading="loading"
                    @click="updateAddHandle" autofocus/>
        </template>

    </Dialog>
    <Card class="p-card shadow-2 p-2 flex flex-column gap-2">

        <template #header>
            <div class="text-3xl m-2">Объявления</div>
        </template>

        <template #content>

            <div class="flex flex-column gap-3">
                <div>
                    <Toolbar>
                        <template #start>
                            <Button text outlined icon="pi pi-plus" severity="success" @click="addAdd"></Button>
                        </template>
                    </Toolbar>
                </div>
                <div class="grid gap-2">
                    <Card v-for="add in adds" :key="add.id" class="p-2 max-w-25rem shadow-2">
                        <template #header>
                            <div class="flex flex-column gap-0">
                                <div class="flex flex-row gap-1 w-full justify-content-end">
                                    <Button text severity="warn" outlined icon="pi pi-pencil" @click="updateAdd(add.id)"></Button>
                                    <Button text severity="danger" outlined icon="pi pi-trash" @click="deleteAdd($event, add.id)"></Button>
                                </div>
                                <div class="m-1 text-xl">{{ add.title }}</div>
                            </div>
                        </template>
                        <template #content>
                            <div class="flex flex-column gap-1">
                                <div class="text-sm"> {{ add.text }}</div>
                                <div class="flex flex-row gap-1">
                                    <div class="col-6 m-2">
                                        <Chip :label="add.status" :style="getChipColor(add.status)" class="w-full m-2 text-center"></Chip>
                                    </div>
                                    <div class="flex align-items-center col-5 m-2"><a :href="add.url">Ссылка</a></div>
                                </div>
                                <div class="flex flex-column gap-1">СРМ: {{ add.crm }}</div>
                                <div class="flex flex-column gap-1">Бюджет: {{ add.budget }}</div>
                                <div><Button class="w-full" outlined :label="add.button_text"></Button></div>
                            </div>
                        </template>
                        <template #footer>
                            <div class="flex justify-content-end w-full">
                                <div class="flex flex-row gap-1"><i class="pi pi-eye"></i>{{ add.impressions_count }}</div>
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
        </template>
    </Card>

</template>

<style scoped>

</style>