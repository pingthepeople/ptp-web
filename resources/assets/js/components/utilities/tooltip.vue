<template>
    <span class="tooltip">
        <a :class="'tooltip__trigger' + (lingering ? ' is-lingering' : '')" href="javascript:void(0)" @mouseout="linger">
            <slot name="tooltip-trigger"></slot>
        </a>
        <div class="tooltip__content">
            <slot name="tooltip-content"></slot>
        </div>
    </span>
</template>

<script>
    module.exports = {
        data() {
            return {
                lingering: false
            }
        },
        methods: {
            linger() {
                if(!this.lingering) {
                    this.lingering = true
                    setTimeout(() => {
                        this.lingering = false
                    }, 500)
                }
            }
        }
    }
</script>