export function formatDate(date) {
    const d = new Date(date)
    const a =
        (d.getDate() < 10 ? '0' + d.getDate() : d.getDate()) +
        '/' +
        (d.getMonth() + 1 < 10 ? '0' + d.getMonth() + 1 : d.getMonth() + 1) +
        '/' +
        d.getFullYear()
    return a
}
