import { configureStore } from '@reduxjs/toolkit'
import authReducer     from './slices/authSlice'
import formationsReducer from './slices/formationsSlice'
import productsReducer from './slices/productsSlice'
import categoriesReducer from './slices/categoriesSlice'
import uiReducer       from './slices/uiSlice'
import settingsReducer from './slices/settingsSlice'

export const store = configureStore({
  reducer: {
    auth:       authReducer,
    formations: formationsReducer,
    products:   productsReducer,
    categories: categoriesReducer,
    ui:         uiReducer,
    settings:   settingsReducer,
  },
  middleware: (getDefault) => getDefault({ serializableCheck: false }),
})

export default store
