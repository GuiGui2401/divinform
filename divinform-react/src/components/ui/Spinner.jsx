export default function Spinner({ size = 'md', color = 'blue-dark' }) {
  const sizes = { sm: 'w-4 h-4', md: 'w-8 h-8', lg: 'w-12 h-12' }
  return (
    <div className={`${sizes[size]} animate-spin rounded-full border-2 border-gray-200 border-t-blue-mid`} />
  )
}
