export function truncate(fullStr, strLen, separator) {
    if (fullStr.length <= strLen) return fullStr

    separator = separator || '...'

    const sepLen = separator.length
    const charsToShow = strLen - sepLen
    const frontChars = Math.ceil(charsToShow / 2)
    const backChars = Math.floor(charsToShow / 2)

    return fullStr.substr(0, frontChars) + separator + fullStr.substr(fullStr.length - backChars)
}
// export function truncateSpace(fullStr, strLen, separator) {
//     const arrString = fullStr.split(' ')
//     if (arrString.length <= strLen) return fullStr
//     const result = []
//     separator = separator || ' ... '
//
//     result.push(arrString.splice(2, arrString.length))
//     result.push(separator)
//     result.push(arrString.pop())
//     return result.join(' ')
// }

export function truncateSpace(str, n, useWordBoundary) {
    if (str.length <= n) {
        return str
    }
    const subString = str.substr(0, n - 1) // the original check
    return (useWordBoundary ? subString.substr(0, subString.lastIndexOf(' ')) : subString) + ' ...'
}
