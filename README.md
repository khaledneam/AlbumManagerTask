# AlbumManager Task

A brief description of your project.

## Table of Contents

- [Features](#features)
  - [Create Album](#create-album)
  - [Edit Album](#edit-album)
  - [Delete Album](#delete-album)
  - [Add Pictures to Album](#add-pictures-to-album)
  - [Delete Picture from Album](#delete-picture-from-album)
  - [Move and Delete Album](#move-and-delete-album)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Features

### Create Album

- **Description**: Users can create a new album by providing an album name.
- **Implementation**: A form that takes the album name and saves it to the database.

### Edit Album

- **Description**: Users can edit the details of an existing album.
- **Implementation**: A form that allows users to update the album name. The changes are saved to the database.

### Delete Album

- **Description**: Users can delete an album.
- **Implementation**: A button that deletes the selected album from the database.

### Add Pictures to Album

- **Description**: Users can add pictures to an album. Each picture must have a name.
- **Implementation**: A form that allows users to upload pictures with names. The pictures are saved to the specified album in the database.

### Delete Picture from Album

- **Description**: Users can delete a picture from an album.
- **Implementation**: A button next to each picture that allows users to delete the picture. The picture is removed from the database and the storage.

### Move and Delete Album

#### Description

This feature allows users to either move pictures to another album before deleting the current album or delete the album along with all its pictures.

#### Usage

- **Move Pictures to Another Album**:
  1. Select the album you want to delete.
  2. Choose the option to move pictures to another album.
  3. Select the target album from the dropdown list.
  4. Confirm the deletion.

- **Delete Album with Pictures**:
  1. Select the album you want to delete.
  2. Choose the option to delete the album along with all its pictures.
  3. Confirm the deletion.

#### Implementation Details

- **Controller**:
  - The `destroy` method in the controller checks the `action` parameter and either moves the pictures to another album or deletes all pictures before deleting the album.
  - The `movePicturesToAnotherAlbum` method moves all pictures from the current album to the target album.
  - The `deleteAllPictures` method deletes each picture file from storage and removes the picture record from the database.

- **JavaScript**:
  - When the `confirm-move` button is clicked, the target album ID is included in the form and AJAX request.
  - The `change` event listener on the radio buttons triggers an AJAX request to fetch all albums and populate the select box when the transfer option is selected.

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/khaledneam/AlbumManagerTask.git
   cd your-repository
