<?php @include '../../_includes/pageSetup.php'; ?>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Demographics</h1>
                <p class="lead">Please answer the following questions as they pertain to you and your experiences.</p>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-lg-12">
                <div class="well bs-component">
                    <form>
                        <fieldset>
                            <div class="form-group col-sm-4">
                                <label for="inputAge" class="control-label">What is your current age?</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="inputAge">
                                    <span class="input-group-addon">yrs</span>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputGender" class="control-label">What is your gender?</label>
                                <div>
                                    <input type="text" class="form-control" id="inputGender">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputBirthplace" class="control-label">Where were you born?</label>
                                <div>
                                    <input type="text" class="form-control" id="inputBirthplace">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="inputLocationRaised" class="control-label">Where did you grow up? You
                                        may list multiple locations if applicable.</label>
                                    <div>
                                        <input type="text" class="form-control" id="inputLocationRaised">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputNativeLanguages" class="control-label">What is (are) your native
                                        language(s)?</label>
                                    <div>
                                        <input type="text" class="form-control" id="inputNativeLanguages">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputEducationLevel" class="control-label">What is your current educational
                                    level or the highest level of education you have completed?</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputEducationLevel" value="A - Middle School">
                                            Middle School
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputEducationLevel" value="B - High School">
                                            High School
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputEducationLevel" value="C - College">
                                            College
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputEducationLevel" value="D - Graduate School">
                                            Graduate School
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputEducationLevel" value="E - Other">
                                            Other
                                        </label>
                                    </div>
                                    <input type="text" class="form-control" name="inputEducationLevelOther"
                                           placeholder="If other, please describe">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="well bs-component">
                    <form>
                        <fieldset>
                            <legend>
                                Please rate your Spanish abilities using the scale provided:
                            </legend>
                            <div class="form-group col-lg-12">
                                <label for="inputSpanishListening" class="control-label">Listening</label>
                                <div>
                                    <label class="radio-inline">
                                        Extremely Poor</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishListening" value="1"> 1</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishListening" value="2"> 2</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishListening" value="3"> 3</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishListening" value="4"> 4</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishListening" value="5"> 5</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishListening" value="6"> 6</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishListening" value="7"> 7</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishListening" value="8"> 8</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishListening" value="9"> 9</label>
                                    <label class="radio-inline">
                                        Extremely Proficient</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputSpanishSpeaking" class="control-label">Speaking</label>
                                <div>
                                    <label class="radio-inline">
                                        Extremely Poor</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishSpeaking" value="1"> 1</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishSpeaking" value="2"> 2</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishSpeaking" value="3"> 3</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishSpeaking" value="4"> 4</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishSpeaking" value="5"> 5</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishSpeaking" value="6"> 6</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishSpeaking" value="7"> 7</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishSpeaking" value="8"> 8</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishSpeaking" value="9"> 9</label>
                                    <label class="radio-inline">
                                        Extremely Proficient</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputSpanishReading" class="control-label">Reading</label>
                                <div>
                                    <label class="radio-inline">
                                        Extremely Poor</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishReading" value="1"> 1</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishReading" value="2"> 2</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishReading" value="3"> 3</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishReading" value="4"> 4</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishReading" value="5"> 5</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishReading" value="6"> 6</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishReading" value="7"> 7</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishReading" value="8"> 8</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishReading" value="9"> 9</label>
                                    <label class="radio-inline">
                                        Extremely Proficient</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputSpanishWriting" class="control-label">Writing</label>
                                <div>
                                    <label class="radio-inline">
                                        Extremely Poor</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishWriting" value="1"> 1</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishWriting" value="2"> 2</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishWriting" value="3"> 3</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishWriting" value="4"> 4</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishWriting" value="5"> 5</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishWriting" value="6"> 6</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishWriting" value="7"> 7</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishWriting" value="8"> 8</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputSpanishWriting" value="9"> 9</label>
                                    <label class="radio-inline">
                                        Extremely Proficient</label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-sm-6">
                                <label for="inputSpanishAge" class="control-label">At what age did you begin learning
                                    Spanish?</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputSpanishAge">
                                    <span class="input-group-addon">yrs</span>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputSpanishWithFamily" class="control-label">Did you grow up speaking
                                    Spanish with your parents or other family members?</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputSpanishWithFamily" value="A - Yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputSpanishWithFamily" value="B - No">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputSpanishUsagePercent" class="control-label">How much Spanish do you use
                                    on a daily basis (please provide a % estimate)?</label>
                                <div class="input-group col-sm-6">
                                    <input type="number" class="form-control" id="inputSpanishUsagePercent"
                                           placeholder="e.g. 25">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="well bs-component">
                    <form>
                        <fieldset>
                            <legend>
                                Please rate your English abilities using the scale provided:
                            </legend>
                            <div class="form-group col-lg-12">
                                <label for="inputEnglishListening" class="control-label">Listening</label>
                                <div>
                                    <label class="radio-inline">
                                        Extremely Poor</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishListening" value="1"> 1</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishListening" value="2"> 2</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishListening" value="3"> 3</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishListening" value="4"> 4</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishListening" value="5"> 5</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishListening" value="6"> 6</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishListening" value="7"> 7</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishListening" value="8"> 8</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishListening" value="9"> 9</label>
                                    <label class="radio-inline">
                                        Extremely Proficient</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputEnglishSpeaking" class="control-label">Speaking</label>
                                <div>
                                    <label class="radio-inline">
                                        Extremely Poor</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishSpeaking" value="1"> 1</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishSpeaking" value="2"> 2</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishSpeaking" value="3"> 3</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishSpeaking" value="4"> 4</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishSpeaking" value="5"> 5</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishSpeaking" value="6"> 6</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishSpeaking" value="7"> 7</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishSpeaking" value="8"> 8</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishSpeaking" value="9"> 9</label>
                                    <label class="radio-inline">
                                        Extremely Proficient</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputEnglishReading" class="control-label">Reading</label>
                                <div>
                                    <label class="radio-inline">
                                        Extremely Poor</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishReading" value="1"> 1</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishReading" value="2"> 2</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishReading" value="3"> 3</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishReading" value="4"> 4</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishReading" value="5"> 5</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishReading" value="6"> 6</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishReading" value="7"> 7</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishReading" value="8"> 8</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishReading" value="9"> 9</label>
                                    <label class="radio-inline">
                                        Extremely Proficient</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputEnglishWriting" class="control-label">Writing</label>
                                <div>
                                    <label class="radio-inline">
                                        Extremely Poor</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishWriting" value="1"> 1</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishWriting" value="2"> 2</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishWriting" value="3"> 3</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishWriting" value="4"> 4</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishWriting" value="5"> 5</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishWriting" value="6"> 6</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishWriting" value="7"> 7</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishWriting" value="8"> 8</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputEnglishWriting" value="9"> 9</label>
                                    <label class="radio-inline">
                                        Extremely Proficient</label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-sm-6">
                                <label for="inputEnglishAge" class="control-label">At what age did you begin learning
                                    English?</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputEnglishAge">
                                    <span class="input-group-addon">yrs</span>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEnglishWithFamily" class="control-label">Did you grow up speaking
                                    English with your parents or other family members?</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputEnglishWithFamily" value="A - Yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputEnglishWithFamily" value="B - No">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputEnglishUsagePercent" class="control-label">How much English do you use
                                    on a daily basis (please provide a % estimate)?</label>
                                <div class="input-group col-sm-6">
                                    <input type="text" class="form-control" id="inputEnglishUsagePercent">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="well bs-component">
                    <form>
                        <fieldset>
                            <legend>
                                For each school level listed below, please indicate whether you received instruction
                                primarily in Spanish, English, both, or not applicable (N/A).
                            </legend>
                            <div class="form-group col-sm-4">
                                <label for="inputInstructionElementary" class="control-label">Elementary School:</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionElementary" value="A - Spanish">
                                            Spanish
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionElementary" value="B - English">
                                            English
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionElementary" value="C - Both">
                                            Both
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionElementary" value="D - NA">
                                            N/A
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputInstructionSecondary" class="control-label">Secondary School:</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionSecondary" value="A - Spanish">
                                            Spanish
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionSecondary" value="B - English">
                                            English
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionSecondary" value="C - Both">
                                            Both
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionSecondary" value="D - NA">
                                            N/A
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputInstructionHS" class="control-label">High School:</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionHS" value="A - Spanish">
                                            Spanish
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionHS" value="B - English">
                                            English
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionHS" value="C - Both">
                                            Both
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionHS" value="D - NA">
                                            N/A
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputInstructionCollege" class="control-label">College:</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionCollege" value="A - Spanish">
                                            Spanish
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionCollege" value="B - English">
                                            English
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionCollege" value="C - Both">
                                            Both
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionCollege" value="D - NA">
                                            N/A
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputInstructionGraduate" class="control-label">Graduate School:</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionGraduate" value="A - Spanish">
                                            Spanish
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionGraduate" value="B - English">
                                            English
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionGraduate" value="C - Both">
                                            Both
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInstructionGraduate" value="D - NA">
                                            N/A
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="well bs-component">
                    <form>
                        <fieldset>
                            <div class="form-group col-lg-12">
                                <label for="inputAdditionalLanguages" class="control-label">Do you speak any additional
                                    languages other than English and Spanish? If YES, then please list each language and
                                    how you learned it. Example responses have been provided.</label>
                                <div>
                                    <textarea class="form-control" rows="3" id="inputAdditionalLanguages"></textarea>
                                    <br>Example 1: I took two years of French in high school and two semesters in
                                    college.<br>
                                    Example 2: I lived in Germany from the ages of 8-12 and attended a German
                                    school.<br><br>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputNonNativeInteraction" class="control-label">How often do you interact
                                    with nonnative speakers of Spanish in Spanish? “Nonnative speakers” refers to
                                    individuals who have learned Spanish as a second language.</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputNonNativeInteraction" value="A - Never">
                                            Never
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputNonNativeInteraction"
                                                   value="B - About once a month">
                                            About once a month
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputNonNativeInteraction"
                                                   value="C - About once a day">
                                            About once a day
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputNonNativeInteraction"
                                                   value="D - More than once a day">
                                            More than once a day
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputInteractionCapacity" class="control-label">In what capacity do you
                                    interact with nonnative speakers of Spanish in Spanish?</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInteractionCapacity"
                                                   value="A - In my professional life">
                                            In my professional life: I interact with nonnative speakers in my work.
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInteractionCapacity"
                                                   value="B - In my personal life">
                                            In my personal life: I have many friends who are nonnative speakers of
                                            Spanish.
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInteractionCapacity" value="C - In both">
                                            In both my personal and professional lives, as described in the options
                                            above.
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInteractionCapacity" value="D - NA">
                                            Not applicable: I do not interact with nonnative speakers of Spanish in
                                            Spanish.
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputInteractionCapacity" value="E - Other">
                                            Other
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputInteractionCapacityOther" class="control-label">If other, please
                                    describe:</label>
                                <div>
                                    <input type="text" class="form-control" id="inputInteractionCapacityOther">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputNonNativeSpanishFamiliarity" class="control-label">How familiar are you
                                    with nonnative speech in Spanish?</label>
                                <div>
                                    <label class="radio-inline">
                                        Not at all familiar</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputNonNativeSpanishFamiliarity" value="1"> 1</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputNonNativeSpanishFamiliarity" value="2"> 2</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputNonNativeSpanishFamiliarity" value="3"> 3</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputNonNativeSpanishFamiliarity" value="4"> 4</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputNonNativeSpanishFamiliarity" value="5"> 5</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputNonNativeSpanishFamiliarity" value="6"> 6</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputNonNativeSpanishFamiliarity" value="7"> 7</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputNonNativeSpanishFamiliarity" value="8"> 8</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inputNonNativeSpanishFamiliarity" value="9"> 9</label>
                                    <label class="radio-inline">
                                        Extremely familiar</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputLinguisticsTraining" class="control-label">Have you received any
                                    linguistics training (in either Spanish or English)?</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputLinguisticsTraining" value="A - Yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputLinguisticsTraining" value="B - No">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputTaughtLanguage" class="control-label">Have you ever taught, either
                                    formally or informally, Spanish or English as a second or foreign language?</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputTaughtLanguage" value="A - Yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inputTaughtLanguage" value="B - No">
                                            No
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group col-lg-12">
                                <label for="inputPersonalInfo" class="control-label">Is there any other personal
                                    information about you that you think would be important for us to know?</label>
                                <div>
                                    <textarea class="form-control" rows="3" id="inputPersonalInfo"></textarea>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="reset" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
