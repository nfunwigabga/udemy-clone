

export function useCurriculum() {
    const route = useRoute()
    const {$api} = useNuxtApp()
    const course = useState('course', () => null)
    const sections = useState('sections', () => [])
    
    async function fetchCurriculum(){
        try {
            const { data } = await $api(`/instructor/c/${route.params.course}/curriculum`)
            course.value = data.value
            sections.value = data.value.sections
        } catch (error) {
            console.error(error)
        }
    }

    async function handleSectionDrag(e){
        if (e.moved) {
            const payload = sections.value.map((section, index) => {
                return { id: section.id, sort_order: index + 1 };
            });
            try {
                const {data} = await $api(`/instructor/c/${route.params.course}/sections/dragged`, {
                    body: payload,
                    method: 'PUT'
                })
                sections.value = data.value
            }catch(error){
                console.log(error)
            }
        }
    }

    async function handleLectureDrag(e){
        if (e.added || e.moved) {
            const payload = sections.value.flatMap((section) =>
                section.lectures.map((lecture) => {
                    return { id: lecture.id, section: section.id };
                })
            )
            payload.forEach((item, index) => (item.sort_order = index + 1));

            try {
                const { data } = await $api(`/instructor/c/${route.params.course}/lectures/dragged`, {
                    body: payload,
                    method: 'PUT'
                })
                sections.value = data.value
            } catch (error) {
                console.log(error)
            }
            
        }
    }

    return {
        fetchCurriculum,
        handleSectionDrag,
        handleLectureDrag
    }
}
