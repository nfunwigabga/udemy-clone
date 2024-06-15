const course = ref(null)

export function useCourse() {
  const route = useRoute()
  const {$api} = useNuxtApp()

  async function setCourse(data){
    course.value = data
  }

  async function fetchCourse(){
      const { data, error } = await $api(`/instructor/c/${route.params.course}`)
      course.value = data.value
      return error
  }

  async function updateCourseStatus() {
      const { data } = await $api(
        `/instructor/c/${route.params.course}/status`,
        {
          method: "PUT",
        }
      );
      setCourse(data.value);
  }

  return {
    course,
    updateCourseStatus,
    fetchCourse,
    setCourse
  }
}
