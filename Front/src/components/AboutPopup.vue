<template>
  <div class="popup-container">
    <div class="popup-content">
      <div class="popup-item">
        <div class="popup-icon">📋</div>
        <div class="popup-text">Tentang Aksi Relawan</div>
      </div>
      <div class="popup-item">
        <div class="popup-icon">🏆</div>
        <div class="popup-text">Visi Misi & Program</div>
      </div>
      <div class="popup-item">
        <div class="popup-icon">💵</div>
        <div class="popup-text">Donasi</div>
      </div>
      <div class="popup-item">
        <div class="popup-icon">📞</div>
        <div class="popup-text">Kontak Kami</div>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.popup-container {
  position: absolute;
  top: 100%;
  left: 0;
  width: 250px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  z-index: 1000;
  padding: 8px 0;
}

.popup-content {
  display: flex;
  flex-direction: column;
}

.popup-item {
  display: flex;
  align-items: center;
  padding: 10px 16px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.popup-item:hover {
  background-color: #f5f5f5;
}

.popup-icon {
  font-size: 18px;
  margin-right: 12px;
  width: 24px;
  text-align: center;
}

.popup-text {
  font-size: 14px;
  color: #333;
}
</style>
