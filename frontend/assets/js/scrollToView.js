export function scrollToInputInvalid(refOfForm) {
    for (let i = 0; i < refOfForm.inputs.length; i++) {
        if (!refOfForm.inputs[i].valid) {
            refOfForm.inputs[i].focus()
            break
        }
    }
}
