<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#" @click="previousPage">Previous</a></li>
            <li class="page-item" v-for="pageNumber in pages.slice(page-1, page+5)" :key="pageNumber" @click="page = pageNumber">
                <a class="page-link" href="#">{{ pageNumber }}</a>
            </li>
            <li class="page-item"><a class="page-link" href="#" @click="nextPage">Next</a></li>
        </ul>
    </nav>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                page: 1,
                perPage: 10,
                pages: [],
            }
        },
        computed: {
            ...mapGetters({
                messages: 'MessageStore/messages'
            }),
        },
        methods: {
            setPages() {
                let numberOfPages = Math.ceil(this.messages.length / this.perPage);

                for (let index = 1; index <= numberOfPages; index++) 
                {
                    this.pages.push(index);
                }
            },
            previousPage() {
                this.page > 0 && this.page--;
            },
            nextPage() {
                this.page < this.pages.length && this.page++;
            }
        },
         watch: {
            messages() {
                this.setPages();
            }
        }
    }
</script>
