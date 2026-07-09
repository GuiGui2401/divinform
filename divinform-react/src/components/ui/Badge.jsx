export default function Badge({ text, color = '#86C34A' }) {
  if (!text) return null
  return (
    <span
      className="absolute top-3 left-3 text-white text-xs font-bold px-2.5 py-1 rounded-full z-10"
      style={{ backgroundColor: color }}
    >
      {text}
    </span>
  )
}
