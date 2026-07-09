import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import { settingsAPI } from '@/api/settings'
import { setSettingsCache } from '@/utils/settingsStore'

export const fetchSettings = createAsyncThunk('settings/fetch', async () => {
  const res = await settingsAPI.getPublic()
  return res.data.data
})

const settingsSlice = createSlice({
  name: 'settings',
  initialState: { values: {}, loaded: false },
  reducers: {},
  extraReducers: (builder) => {
    builder.addCase(fetchSettings.fulfilled, (s, { payload }) => {
      s.values = payload || {}
      s.loaded = true
      setSettingsCache(s.values)   // expose aux utilitaires non-React
    })
  },
})

export default settingsSlice.reducer
export const selectSettings       = (s) => s.settings.values
export const selectSettingsLoaded = (s) => s.settings.loaded
