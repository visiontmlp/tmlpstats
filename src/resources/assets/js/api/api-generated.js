//// THIS FILE IS AUTOMATICALLY GENERATED!
//// DO NOT EDIT BY HAND!

import { buildApiCaller } from './callers'

const bac = buildApiCaller

var Api = {}

Api.Admin = {
}

Api.Admin.Region = {

    /*
    get region and centers in region and some other info
    Parameters:
      region: Region
    */
    getRegion: bac('Admin.Region.getRegion')
}

Api.Application = {

    /*
    Create new application
    Parameters:
      data: array
    */
    create: bac('Application.create'),

    /*
    Update an application
    Parameters:
      application: Application
      data: array
    */
    update: bac('Application.update'),

    /*
    List applications by center
    Parameters:
      center: Center
      reportingDate: date
      includeInProgress: bool
    */
    allForCenter: bac('Application.allForCenter'),

    /*
    Get the weekly data for an application
    Parameters:
      application: Application
      reportingDate: date
    */
    getWeekData: bac('Application.getWeekData'),

    /*
    Stash combined data for an application
    Parameters:
      center: Center
      reportingDate: date
      data: array
    */
    stash: bac('Application.stash')
}

Api.Context = {

    /*
    Get the current center
    Parameters:
    */
    getCenter: bac('Context.getCenter'),

    /*
    Set the current center
    Parameters:
      center: Center
      permanent: bool
    */
    setCenter: bac('Context.setCenter'),

    /*
    Get a single setting value given a center
    Parameters:
      name: string
      center: Center
    */
    getSetting: bac('Context.getSetting')
}

Api.Course = {

    /*
    Create new course
    Parameters:
      data: array
    */
    create: bac('Course.create'),

    /*
    Update a course
    Parameters:
      course: Course
      data: array
    */
    update: bac('Course.update'),

    /*
    List courses by center
    Parameters:
      center: Center
      reportingDate: date
      includeInProgress: bool
    */
    allForCenter: bac('Course.allForCenter'),

    /*
    Get the weekly data for an course
    Parameters:
      course: Course
      reportingDate: date
    */
    getWeekData: bac('Course.getWeekData'),

    /*
    Stash combined data for an course
    Parameters:
      center: Center
      reportingDate: date
      data: array
    */
    stash: bac('Course.stash')
}

Api.GlobalReport = {

    /*
    Get ratings for all teams
    Parameters:
      globalReport: GlobalReport
      region: Region
    */
    getRating: bac('GlobalReport.getRating'),

    /*
    Get scoreboard for all weeks within a quarter
    Parameters:
      globalReport: GlobalReport
      region: Region
    */
    getQuarterScoreboard: bac('GlobalReport.getQuarterScoreboard'),

    /*
    Get scoreboard for a single week within a quarter
    Parameters:
      globalReport: GlobalReport
      region: Region
      futureDate: date
    */
    getWeekScoreboard: bac('GlobalReport.getWeekScoreboard'),

    /*
    Get scoreboard for a single week within a quarter by center
    Parameters:
      globalReport: GlobalReport
      region: Region
      options: array
    */
    getWeekScoreboardByCenter: bac('GlobalReport.getWeekScoreboardByCenter'),

    /*
    Get the list of incoming team members by center
    Parameters:
      globalReport: GlobalReport
      region: Region
      options: array
    */
    getApplicationsListByCenter: bac('GlobalReport.getApplicationsListByCenter'),

    /*
    Get the list of team members by center
    Parameters:
      globalReport: GlobalReport
      region: Region
      options: array
    */
    getClassListByCenter: bac('GlobalReport.getClassListByCenter'),

    /*
    Get the list of courses
    Parameters:
      globalReport: GlobalReport
      region: Region
    */
    getCourseList: bac('GlobalReport.getCourseList')
}

Api.LiveScoreboard = {

    /*
    Get scores for a center
    Parameters:
      center: Center
    */
    getCurrentScores: bac('LiveScoreboard.getCurrentScores'),

    /*
    Set a single score
    Parameters:
      center: Center
      game: string
      type: string
      value: int
    */
    setScore: bac('LiveScoreboard.setScore')
}

Api.LocalReport = {

    /*
    Get scoreboard for all weeks within a quarter
    Parameters:
      localReport: LocalReport
      options: array
    */
    getQuarterScoreboard: bac('LocalReport.getQuarterScoreboard'),

    /*
    Get scoreboard for a single week within a quarter
    Parameters:
      localReport: LocalReport
    */
    getWeekScoreboard: bac('LocalReport.getWeekScoreboard'),

    /*
    Get the list of incoming team members
    Parameters:
      localReport: LocalReport
      options: array
    */
    getApplicationsList: bac('LocalReport.getApplicationsList'),

    /*
    Get the list of all team members
    Parameters:
      localReport: LocalReport
    */
    getClassList: bac('LocalReport.getClassList'),

    /*
    Get the list of all team members, arranged by T1/T2 and by quarter
    Parameters:
      localReport: LocalReport
    */
    getClassListByQuarter: bac('LocalReport.getClassListByQuarter'),

    /*
    Get the list of courses
    Parameters:
      localReport: LocalReport
    */
    getCourseList: bac('LocalReport.getCourseList')
}

Api.Scoreboard = {

    /*
    Get scoreboard data for center
    Parameters:
      center: Center
      reportingDate: date
      includeInProgress: bool
    */
    allForCenter: bac('Scoreboard.allForCenter'),

    /*
    Save scoreboard data for week
    Parameters:
      center: Center
      reportingDate: date
      data: array
    */
    stash: bac('Scoreboard.stash'),

    /*
    TBD
    Parameters:
      center: Center
      quarter: Quarter
    */
    getScoreboardLockQuarter: bac('Scoreboard.getScoreboardLockQuarter'),

    /*
    TBD
    Parameters:
      center: Center
      quarter: Quarter
      data: array
    */
    setScoreboardLockQuarter: bac('Scoreboard.setScoreboardLockQuarter')
}

Api.SubmissionCore = {

    /*
    Initialize Submission, checking date extents and center and providing some useful starting data
    Parameters:
      center: Center
      reportingDate: date
    */
    initSubmission: bac('SubmissionCore.initSubmission')
}

Api.SubmissionData = {

    /*
    Ignore Me. Maybe I&#039;ll have public methods in the future.
    Parameters:
      center: string
      timezone: string
    */
    ignoreMe: bac('SubmissionData.ignoreMe')
}

Api.TeamMember = {

    /*
    Create new team member
    Parameters:
      data: array
    */
    create: bac('TeamMember.create'),

    /*
    Update an team member
    Parameters:
      teamMember: TeamMember
      data: array
    */
    update: bac('TeamMember.update'),

    /*
    Set the weekly data for an team member
    Parameters:
      teamMember: TeamMember
      reportingDate: date
      data: array
    */
    setWeekData: bac('TeamMember.setWeekData'),

    /*
    Get team member data for a center-reportingDate, optionally including in-progress data
    Parameters:
      center: Center
      reportingDate: date
      includeInProgress: bool
    */
    allForCenter: bac('TeamMember.allForCenter')
}

Api.UserProfile = {

    /*
    Set locale information
    Parameters:
      locale: string
      timezone: string
    */
    setLocale: bac('UserProfile.setLocale')
}

Api.ValidationData = {

    /*
    Validate report data and return results
    Parameters:
      center: Center
      reportingDate: date
    */
    validate: bac('ValidationData.validate')
}


export default Api
