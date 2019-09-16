<template>
    <span v-if="roleId === 1">
        <i class="fas fa-chess-pawn"></i>
    </span>
    <span v-else-if="roleId === 2">
        <i class="fas fa-chess-knight"></i>
    </span>
    <span v-else-if="roleId === 3">
        <i class="fas fa-chess-queen"></i>
    </span>
    <span v-else-if="roleId === 4">
        <i class="fas fa-dice-d20"></i>
    </span>
</template>

<script>
    export default {
        name: "userIcon",
        props: {
            roleId: {
                type: Number,
                required: true
            }
        },
    }
</script>
