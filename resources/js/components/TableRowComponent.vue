<template>
    <tr :class="{'table-success' : marked}">
        <th class="align-middle" scope="row">{{application['id']}}</th>
        <td class="align-middle">{{application['subject']}}</td>
        <td class="align-middle" colspan="2">{{application['message']}}</td>
        <td class="align-middle">{{user['name']}}</td>
        <td class="align-middle">{{user['email']}}</td>
        <td class="align-middle"><a :href="application['file']">Скачать</a></td>
        <td class="align-middle">{{application['created_at']}}</td>
        <td class="align-middle">
            <div class="form-group form-check text-center">
                <input type="checkbox" class="form-check-input" @change="submit" v-model="marked">
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        data () {
            return {
                marked: false
            }
        },
        props:  [
            'application',
            'user',
            'route',
            'csrf'
        ],
        methods: {
            submit: function() {

                const formData = new FormData();
                formData.set('_method', 'PATCH');
                formData.set('_token', this.csrf);
                formData.set('marked', +this.marked);

                axios.post(this.route, formData, {
                    _method: 'patch'
                })
                .then((response) => {
                    this.marked = !!response.data;
                })
            }
        },
        mounted() {
            this.marked = !!this.application['marked'];
        }
    }
</script>
