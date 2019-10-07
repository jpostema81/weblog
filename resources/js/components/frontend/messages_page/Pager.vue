<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#" @click="previousPage">Previous</a></li>
            <li :class="{'page-item':true, 'active':(pageNumber === page)}" v-for="pageNumber in pageBlock" :key="pageNumber" 
                @click="updatePageNumber(pageNumber)">
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
            pageBlock() {
                let from = this.page - 1;
                let to = this.page + 5;

                return this.pages.slice(from, to);
            },
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
                this.page > 1 && this.page--;
                this.$store.dispatch('MessageStore/fetchMessages', this.page);
            },
            nextPage() {
                this.page < this.pages.length && this.page++;
                this.$store.dispatch('MessageStore/fetchMessages', this.page);
            },
            updatePageNumber(pageNumber) {
                this.page = pageNumber;
                this.$store.dispatch('MessageStore/fetchMessages', this.page);
            }
        },
         watch: {
            messages() {
                this.setPages();
            }
        }
    }
</script>
