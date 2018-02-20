<template>
    <div v-if="nPages>1">
        <ul class="pager hide-sm-down">
            <li class="pager__item">
                <a class="pager__link" @click.prevent="pageTo(currentPage)" href="javascript:void(0)">
                    Previous
                </a>
            </li>
            <li class="pager__item" v-for="page in nPages">
                <a :class="'pager__link'+(currentPage+1==page ? ' is-active' : '')" @click.prevent="pageTo(page)" href="javascript:void(0)">
                    {{page}}
                </a>
            </li>
            <li class="pager__item">
                <a class="pager__link" @click.prevent="pageTo(currentPage+2)" href="javascript:void(0)">
                    Next
                </a>
            </li>
        </ul>
        <div class="pager pager--mobile">
            <label class="pager__select-label" for="page-select">
                Jump to page<br>
                <select id="page-select" class="pager__select" @change="pageTo(selected)" v-model.number="selected">
                    <option v-for="page in nPages" :value="page" :selected="currentPage+1==page">{{page}}</option>
                </select>
            </label>
            
            <a class="pager__link" @click.prevent="pageTo(currentPage)" href="javascript:void(0)">
                Previous
            </a>
            
            <a class="pager__link" @click.prevent="pageTo(currentPage+2)" href="javascript:void(0)">
                Next
            </a>
        </div>
    </div>
</template>

<script type="text/babel">
    module.exports = {
        data() {
            return {
                selected: this.currentPage+1
            }
        },
        props: [
            'nPages',
            'currentPage',
            'pageTo'
        ],
        watch: {
            currentPage() {
                this.selected = this.currentPage+1;
            }
        }
    }
</script>