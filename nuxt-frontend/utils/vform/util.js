/**
 * Deep copy the given object.
 */
export function deepCopy (obj) {
    if (obj === null || typeof obj !== 'object') {
      return obj
    }
  
    const copy = Array.isArray(obj) ? [] : {}
  
    Object.keys(obj).forEach((key) => {
      copy[key] = deepCopy((obj)[key])
    })
  
    return copy
}
  
/**
 * If the given value is not an array, wrap it in one.
 */
export function arrayWrap(value) {
  return Array.isArray(value) ? value : [value]
}
  