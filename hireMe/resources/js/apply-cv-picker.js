export default (config) => ({
    resumeChoice: config.resumeChoice,
    previousChoice: config.previousChoice,
    selectedLabel: config.selectedLabel,
    uploadNewLabel: config.uploadNewLabel,
    chooseFileLabel: config.chooseFileLabel,
    newFileName: '',
    menuOpen: false,
    resumes: config.resumes,
    openNewCv() {
        this.$nextTick(() => this.$refs.cvInput?.click());
    },
    selectExisting(id, name) {
        this.resumeChoice = id;
        this.previousChoice = id;
        this.selectedLabel = name;
        this.newFileName = '';
        this.menuOpen = false;
        this.$refs.cvInput.value = '';
    },
    selectNew() {
        this.resumeChoice = 'new';
        this.selectedLabel = this.uploadNewLabel;
        this.menuOpen = false;
        this.openNewCv();
    },
    onFileChosen(event) {
        const file = event.target.files[0];
        if (file) {
            this.newFileName = file.name;
            this.selectedLabel = file.name;
            this.resumeChoice = 'new';
            this.previousChoice = 'new';
        } else if (this.resumes.length > 0) {
            this.resumeChoice = this.previousChoice;
            const match = this.resumes.find((r) => r.id === this.previousChoice);
            this.selectedLabel = match ? match.name : this.uploadNewLabel;
            this.newFileName = '';
        }
    },
});
