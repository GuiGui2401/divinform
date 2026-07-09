import { createSlice } from '@reduxjs/toolkit'

const uiSlice = createSlice({
  name: 'ui',
  initialState: {
    modalProduct:   null,   // produit ouvert dans le modal
    sidebarOpen:    false,
    searchOpen:     false,
  },
  reducers: {
    openProductModal:  (s, { payload }) => { s.modalProduct = payload },
    closeProductModal: (s) => { s.modalProduct = null },
    toggleSidebar:     (s) => { s.sidebarOpen = !s.sidebarOpen },
    closeSidebar:      (s) => { s.sidebarOpen = false },
  },
})

export const { openProductModal, closeProductModal, toggleSidebar, closeSidebar } = uiSlice.actions
export default uiSlice.reducer

export const selectModalProduct = (s) => s.ui.modalProduct
export const selectSidebarOpen  = (s) => s.ui.sidebarOpen
