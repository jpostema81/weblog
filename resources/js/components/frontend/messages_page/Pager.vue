<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#" @click="previousPage">Previous</a></li>
            <li :class="{'page-item':true, 'active':(pageNumber === currentPage)}" v-for="pageNumber in pageBlock" :key="pageNumber" 
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
                currentPage: '',
                perPage: '',
                firstPage: 1,
                lastPage: '',
                nbPagesShow: 5,
            }
        },
        computed: {
            ...mapGetters({
                messages: 'MessageStore/messages',
                meta: 'MessageStore/meta'
            }),
            pageBlock() {
                let from = this.currentPage;
                let to = this.currentPage + this.nbPagesShow;
                let pages = [];

                if(this.currentPage <= Math.ceil(this.nbPagesShow / 2))
                {
                    from = this.firstPage;
                    to = this.nbPagesShow;
                } else {
                    if(this.currentPage > this.lastPage - Math.floor(this.nbPagesShow / 2))
                    {
                        from = this.lastPage - this.nbPagesShow + 1;
                        to = this.lastPage;
                    }
                    else
                    {
                        let offset = Math.floor(this.nbPagesShow / 2);
                        from = this.currentPage - offset;
                        to = this.currentPage + offset;
                    }
                }

                for(let i=from; i<to+1; i++)
                {   
                    pages.push(i);
                }

                return pages;
            },
        },
        methods: {
            setPages() {
                this.currentPage = this.meta.current_page; 
                this.perPage = this.meta.per_page;
                this.lastPage = this.meta.last_page;
            },
            previousPage() {
                if(this.currentPage > 1)
                {
                    this.currentPage--;
                    this.$store.dispatch('MessageStore/fetchAllMessages', this.currentPage);
                }
            },
            nextPage() {
                if(this.currentPage < this.lastPage)
                {
                    this.currentPage++;
                    this.$store.dispatch('MessageStore/fetchAllMessages', this.currentPage);
                }
            },
            updatePageNumber(pageNumber) {
                this.currentPage = pageNumber;
                this.$store.dispatch('MessageStore/fetchAllMessages', this.currentPage);
            }
        },
         watch: {
            messages() {
                this.setPages();
            }
        }
    }
</script>
