<template>
  <div class="card">
    <div v-if="$slots.header" class="card-header">
      <slot name="header"></slot>
    </div>
    <div class="card-content">
      <slot></slot>
    </div>
  </div>
</template>

<style scoped>
.card {
  background-color: var(--white);
  border-radius: var(--border-radius-lg);
  box-shadow: var(--shadow-md);
  overflow: hidden;
}

.card-header {
  padding: var(--spacing-lg);
  border-bottom: 1px solid var(--gray-200);
}

.card-header h3 {
  margin: 0;
  color: var(--gray-900);
  font-size: 1.1rem;
}

.card-content {
  padding: var(--spacing-lg);
}
</style> 