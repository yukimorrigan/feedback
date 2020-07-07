<template>
    <div>
        <label for="customFileLang">Файл</label>
        <div class="custom-file mb-3">
            <input name="file" type="file" class="custom-file-input" :class="{'is-invalid':hasError}" id="customFileLang"
                   lang="ru" @change="checkSize" ref="file">
            <label class="custom-file-label" for="customFileLang">Загрузить файл</label>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                hasError: false
            }
        },
        props: [
            'error'
        ],
        mounted() {
            this.hasError=this.error
        },
        methods: {
            checkSize(e) {
                this.hasError = false

                const file = this.$refs.file.files[0];

                if (!file) {
                    e.preventDefault();
                    this.hasError = true
                    alert('Файл не выбран. Выберите файл.');
                    return;
                }

                if (file.size > 1000000) {
                    e.preventDefault();
                    this.hasError = true
                    alert('Размер файла не должен привышать 1MB');
                    this.$refs.file.value = '';
                    return;
                }
            }
        }
    }
</script>
